<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * WsSparePartCategory — Spare Parts Category master.
 *
 * Used as the canonical list for:
 *  - wsspareparts.category_id  (spare parts categorisation)
 *  - Spare Vendor specialisation chips
 */
class WsSparePartCategory extends Model
{
    use SoftDeletes;

    protected $table = 'wssparepartscategories';

    protected $fillable = [
        'organisation_id',
        'name',
        'code',
        'description',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function spareParts()
    {
        return $this->hasMany(WsSparePart::class, 'category_id');
    }
}
