<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * Unified Workshop model.
 *
 * Replaces the former Servicecentre (Own) and Externalservicecentre (External) models.
 * The `ownership` column ('Own' | 'External') determines the workshop type.
 *
 * @property int         $id
 * @property string      $workshop_code
 * @property string      $name
 * @property string      $ownership          Own | External
 * @property string      $workshop_type      Workshop | Mobile Unit | Hybrid | Brand ASC | Third Party | Warranty | Multi-Brand
 * @property string|null $brand
 * @property string|null $city
 * @property string|null $state
 * @property string|null $address
 * @property string|null $pincode
 * @property string|null $manager_name
 * @property string|null $contact_phone
 * @property string|null $contact_email
 * @property int         $technician_count
 * @property string|null $notes
 * @property string      $status             Active | Inactive
 */
class Workshop extends Model
{
    use SoftDeletes;

    protected $table = 'workshops';

    protected $guarded = [];

    // ── Scopes ───────────────────────────────────────────────────────────────

    /** Filter to own (company) workshops. */
    public function scopeOwn(Builder $query): Builder
    {
        return $query->where('ownership', 'Own');
    }

    /** Filter to external workshops / ASCs. */
    public function scopeExternal(Builder $query): Builder
    {
        return $query->where('ownership', 'External');
    }

    /** Active workshops only. */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'Active');
    }

    // ── Relationships ────────────────────────────────────────────────────────

    public function insuranceclaims()
    {
        return $this->hasMany(Insuranceclaim::class, 'workshop_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ── Auto-generate workshop code ──────────────────────────────────────────

    /**
     * Generate the next workshop code.
     *
     * Own workshops  → WS-{CITY}-001
     * External workshops → WS-EXT-001
     *
     * @param  string $ownership 'Own' | 'External'
     * @param  string $city      City abbreviation for Own workshops
     */
    public static function nextWorkshopCode(string $ownership, string $city = 'GEN'): string
    {
        $cityTag = $ownership === 'External'
            ? 'EXT'
            : strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $city), 0, 3));

        $prefix = 'WS-' . $cityTag . '-';

        $last = static::where('workshop_code', 'like', $prefix . '%')
                      ->orderByDesc('workshop_code')
                      ->value('workshop_code');

        $seq = $last ? (intval(substr($last, -3)) + 1) : 1;

        return $prefix . str_pad($seq, 3, '0', STR_PAD_LEFT);
    }
}
