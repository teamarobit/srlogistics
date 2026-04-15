<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SparePart extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'wsspareparts';

    protected $fillable = [
        'part_no',
        'name',
        'category',
        'wssparepartscategory_id',
        'compatible_makes',
        'unit',
        'standard_cost',
        'reorder_level',
        'status',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'standard_cost' => 'decimal:2',
        'reorder_level' => 'integer',
    ];

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
              ->orWhere('part_no', 'like', "%{$term}%");
        });
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    /**
     * Relationship to WsSparePartCategory.
     * Named 'partCategory' to avoid collision with the legacy 'category' text column.
     */
    public function partCategory()
    {
        return $this->belongsTo(WsSparePartCategory::class, 'wssparepartscategory_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Stock balances for this part across all locations.
     * location_type = 'spare_part' in wsstockbalances
     */
    public function stockBalances()
    {
        return $this->hasMany(WsStockBalance::class, 'item_id')
                    ->where('item_type', 'spare_part');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /** Generate the next part number: SP-0001, SP-0002, … */
    public static function nextPartNo(): string
    {
        $max = static::withTrashed()->max('id') ?? 0;
        return 'SP-' . str_pad($max + 1, 4, '0', STR_PAD_LEFT);
    }

    /** Total on-hand quantity across all locations (computed from wsstockbalances) */
    public function totalStock(): float
    {
        return (float) $this->stockBalances()->sum('quantity');
    }
}
