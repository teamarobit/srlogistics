<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;

    protected $table = 'warehouses';

    protected $fillable = [
        'organisation_id',
        'warehouse_code',
        'name',
        'warehouse_type',
        'address',
        'location_name',
        'state_id',
        'city_name',
        'pincode',
        'manager_contact_id',
        'contact_number',
        'storage_type',
        'notes',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function manager()
    {
        return $this->belongsTo(Contact::class, 'manager_contact_id');
    }

    /** Existing tyre relationship (preserved) */
    public function tyres()
    {
        return $this->hasMany(Tyre::class);
    }

    /** Tyre movement / history logs for this warehouse */
    public function tyrelogs()
    {
        return $this->hasMany(Tyrelog::class, 'warehouse_id');
    }

    /** Batteries currently parked at this warehouse */
    public function batteries()
    {
        return $this->hasMany(Battery::class, 'warehouse_id');
    }

    /** Battery movement / history logs for this warehouse */
    public function batterylogs()
    {
        return $this->hasMany(Batterylog::class, 'warehouse_id');
    }

    /** Location-wise stock balances at this warehouse */
    public function stockBalances()
    {
        return $this->hasMany(WsStockBalance::class, 'location_id')
                    ->where('location_type', 'warehouse');
    }

    /** Stock ledger entries arriving at this warehouse (inward leg) */
    public function stockLedgerIn()
    {
        return $this->hasMany(WsStockLedger::class, 'to_location_id')
                    ->where('to_location_type', 'warehouse');
    }

    /** Stock ledger entries leaving this warehouse (outward leg) */
    public function stockLedgerOut()
    {
        return $this->hasMany(WsStockLedger::class, 'from_location_id')
                    ->where('from_location_type', 'warehouse');
    }

    /** Backwards-compatible alias for the inward stock ledger relation. */
    public function stockLedger()
    {
        return $this->stockLedgerIn();
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /** Generate the next warehouse code: WH-001 */
    public static function nextCode(): string
    {
        $max = static::withTrashed()->max('id') ?? 0;
        return 'WH-' . str_pad($max + 1, 3, '0', STR_PAD_LEFT);
    }
}
