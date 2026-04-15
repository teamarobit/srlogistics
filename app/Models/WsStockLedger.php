<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * WsStockLedger — immutable stock transaction log.
 *
 * Every stock movement is recorded here and the corresponding
 * WsStockBalance row is updated in the same DB transaction.
 *
 * Transaction types:
 *   Opening    — initial stock load at a location
 *   Purchase   — goods received from a vendor (IN)
 *   Issue      — issued from a location to a job card (OUT)
 *   Return     — parts returned from job card back to location (IN)
 *   Transfer   — moved between warehouse ↔ workshop
 *   Adjustment — stock-take correction (positive or negative qty)
 *   Scrap      — write-off (OUT)
 */
class WsStockLedger extends Model
{
    use SoftDeletes;

    protected $table = 'wsstockledger';

    protected $fillable = [
        'organisation_id',
        'txn_no',
        'txn_date',
        'txn_type',
        'item_type',
        'item_id',
        'from_location_type',
        'from_location_id',
        'to_location_type',
        'to_location_id',
        'qty',
        'unit_cost',
        'total_cost',
        'ref_type',
        'ref_id',
        'ref_no',
        'notes',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'txn_date'   => 'date',
        'qty'        => 'decimal:3',
        'unit_cost'  => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopePosted($query)
    {
        return $query->where('status', 'Posted');
    }

    public function scopeForItem($query, string $type, int $id)
    {
        return $query->where('item_type', $type)->where('item_id', $id);
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function sparePart()
    {
        return $this->belongsTo(SparePart::class, 'item_id');
    }

    public function fromWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'from_location_id');
    }

    public function toWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'to_location_id');
    }

    public function fromWorkshop()
    {
        return $this->belongsTo(Workshop::class, 'from_location_id');
    }

    public function toWorkshop()
    {
        return $this->belongsTo(Workshop::class, 'to_location_id');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /** Generate the next sequential transaction number: SL-2026-00001 */
    public static function nextTxnNo(): string
    {
        $year = Carbon::now()->year;
        $max  = static::withTrashed()
                    ->where('txn_no', 'like', "SL-{$year}-%")
                    ->count();
        return 'SL-' . $year . '-' . str_pad($max + 1, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Post a stock transaction and update balances atomically.
     *
     * @param  array  $data  Ledger row data (item_type, item_id, txn_type, qty, etc.)
     * @return static
     */
    public static function post(array $data): static
    {
        return DB::transaction(function () use ($data) {
            $data['txn_no']   = $data['txn_no']   ?? static::nextTxnNo();
            $data['txn_date'] = $data['txn_date']  ?? Carbon::today();
            $data['status']   = 'Posted';

            $ledger = static::create($data);

            // Update balance at destination (IN)
            if (!empty($data['to_location_type']) && !empty($data['to_location_id'])) {
                WsStockBalance::updateOrCreate(
                    [
                        'item_type'     => $data['item_type'],
                        'item_id'       => $data['item_id'],
                        'location_type' => $data['to_location_type'],
                        'location_id'   => $data['to_location_id'],
                    ],
                    []  // created with 0 qty if not exists
                );
                WsStockBalance::where([
                    'item_type'     => $data['item_type'],
                    'item_id'       => $data['item_id'],
                    'location_type' => $data['to_location_type'],
                    'location_id'   => $data['to_location_id'],
                ])->increment('quantity', $data['qty']);
            }

            // Update balance at source (OUT)
            if (!empty($data['from_location_type']) && !empty($data['from_location_id'])) {
                WsStockBalance::where([
                    'item_type'     => $data['item_type'],
                    'item_id'       => $data['item_id'],
                    'location_type' => $data['from_location_type'],
                    'location_id'   => $data['from_location_id'],
                ])->decrement('quantity', $data['qty']);
            }

            return $ledger;
        });
    }
}
