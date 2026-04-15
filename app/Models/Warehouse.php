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
        'city',
        'state',
        'address',
        'pincode',
        'manager_name',
        'contact_phone',
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

    /** Existing tyre relationship (preserved) */
    public function tyres()
    {
        return $this->hasMany(Tyre::class);
    }

    /** Location-wise stock balances at this warehouse */
    public function stockBalances()
    {
        return $this->hasMany(WsStockBalance::class, 'location_id')
                    ->where('location_type', 'warehouse');
    }

    /** Stock ledger entries for this warehouse */
    public function stockLedger()
    {
        return $this->hasMany(WsStockLedger::class, 'to_location_id')
                    ->where('to_location_type', 'warehouse');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /** Generate the next warehouse code: WH-001 */
    public static function nextCode(): string
    {
        $max = static::withTrashed()->max('id') ?? 0;
        return 'WH-' . str_pad($max + 1, 3, '0', STR_PAD_LEFT);
    }
}
