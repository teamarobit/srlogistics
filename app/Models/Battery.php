<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Battery extends Model
{
    use SoftDeletes;

    protected $table = 'batteries';

    protected $guarded = [];

    protected $casts = [
        'battery_purchase_date'        => 'date',
        'battery_warranty_expiry_date' => 'date',
        'battery_issue_date'           => 'date',
        'battery_end_of_life_date'     => 'date',
        'last_voltage_check_date'      => 'date',
        'last_charging_check_date'     => 'date',
        'next_inspection_due_date'     => 'date',
        'installation_date'            => 'date',
        'maintenance_reminder_enabled' => 'boolean',
        'battery_purchase_cost'        => 'decimal:2',
        'battery_capacity'             => 'decimal:2',
    ];

    // ── Relationships ─────────────────────────────────────────────────────

    public function vendor()
    {
        return $this->belongsTo(Contact::class, 'vendor_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'workshop_id');
    }

    public function medias()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function images()
    {
        return $this->morphMany(Media::class, 'mediable')->where('type', 'Image');
    }

    public function documents()
    {
        return $this->morphMany(Media::class, 'mediable')->where('type', 'Document');
    }

    public function batterylogs()
    {
        return $this->hasMany(Batterylog::class, 'battery_id');
    }

    // ── Scopes ────────────────────────────────────────────────────────────

    public function scopeForOrg($query, $orgId = null)
    {
        $orgId = $orgId ?? (auth()->user()->organisation_id ?? 1);
        return $query->where('organisation_id', $orgId);
    }

    public function scopeInStock($query)
    {
        return $query->where('current_status', 'In Stock');
    }
}
