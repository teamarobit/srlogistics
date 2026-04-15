<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * WsStockBalance — current on-hand stock per item per location.
 *
 * One row per (item_type, item_id, location_type, location_id) combination.
 * Updated atomically whenever a WsStockLedger transaction is posted.
 */
class WsStockBalance extends Model
{
    protected $table = 'wsstockbalances';

    // No soft deletes — balances are maintained, never deleted.
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'organisation_id',
        'item_type',
        'item_id',
        'location_type',
        'location_id',
        'quantity',
        'reserved_quantity',
        'reorder_level',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'quantity'          => 'decimal:3',
        'reserved_quantity' => 'decimal:3',
        'reorder_level'     => 'integer',
    ];

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopeForItem($query, string $type, int $id)
    {
        return $query->where('item_type', $type)->where('item_id', $id);
    }

    public function scopeAtLocation($query, string $type, int $id)
    {
        return $query->where('location_type', $type)->where('location_id', $id);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('quantity', '<=', 'reorder_level')
                     ->where('quantity', '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', '<=', 0);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /** Available quantity (on-hand minus reserved) */
    public function availableQty(): float
    {
        return max(0, (float) $this->quantity - (float) $this->reserved_quantity);
    }

    public function isLowStock(): bool
    {
        return $this->quantity > 0 && $this->quantity <= $this->reorder_level;
    }

    public function isOutOfStock(): bool
    {
        return $this->quantity <= 0;
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function sparePart()
    {
        return $this->belongsTo(SparePart::class, 'item_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'location_id');
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'location_id');
    }

    /**
     * Resolve the location model dynamically.
     */
    public function location(): Model|null
    {
        return match ($this->location_type) {
            'warehouse' => $this->warehouse,
            'workshop'  => $this->workshop,
            default     => null,
        };
    }
}
