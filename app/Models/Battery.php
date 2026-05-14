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
        'battery_purchase_date'             => 'date',
        'battery_warranty_expiry_date'      => 'date',
        'battery_issue_date'                => 'date',
        'battery_end_of_life_date'          => 'date',
        'last_voltage_check_date'           => 'date',
        'last_charging_check_date'          => 'date',
        'next_inspection_due_date'          => 'date',
        'installation_date'                 => 'date',
        'in_garage_since'                   => 'date',
        'warranty_claim_date'               => 'date',
        'warranty_expected_closure_date'    => 'date',
        'warranty_new_battery_received_date'=> 'date',
        'repair_sent_date'                  => 'date',
        'repair_expected_closure_date'      => 'date',
        'scrap_sent_date'                   => 'date',
        'maintenance_reminder_enabled'      => 'boolean',
        'battery_purchase_cost'             => 'decimal:2',
        'battery_capacity'                  => 'decimal:2',
        'repair_cost'                       => 'decimal:2',
        'scrap_income'                      => 'decimal:2',
    ];

    // ── Relationships ─────────────────────────────────────────────────────

    public function vendor()
    {
        return $this->belongsTo(Contact::class, 'vendor_id');
    }

    public function repairVendor()
    {
        return $this->belongsTo(Contact::class, 'repair_vendor_id');
    }

    public function scrapVendor()
    {
        return $this->belongsTo(Contact::class, 'scrap_vendor_id');
    }

    public function allocatedVehicle()
    {
        return $this->belongsTo(Vehicle::class, 'allocated_vehicle_id');
    }

    public function scrapLastVehicle()
    {
        return $this->belongsTo(Vehicle::class, 'scrap_last_fitted_vehicle_id');
    }

    public function ytdLastVehicle()
    {
        return $this->belongsTo(Vehicle::class, 'ytd_last_vehicle_id');
    }

    public function trackingGroup()
    {
        return $this->belongsTo(Vehiclegroup::class, 'tracking_group_id');
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

    // ── Computed: warranty remaining months ──────────────────────────────

    public function getWarrantyRemainingMonthsAttribute(): ?int
    {
        if (! $this->battery_warranty_expiry_date) { return null; }
        return max(0, (int) now()->diffInMonths($this->battery_warranty_expiry_date, false));
    }

    // ── Computed: life remaining months ──────────────────────────────────

    public function getLifeRemainingMonthsAttribute(): ?int
    {
        if (! $this->battery_fixed_life_months) { return null; }
        $used = (int) ($this->battery_actual_usage_months ?? 0);
        return max(0, $this->battery_fixed_life_months - $used);
    }

    // ── Computed: life remaining % ────────────────────────────────────────

    public function getLifeRemainingPctAttribute(): ?float
    {
        if (! $this->battery_fixed_life_months || $this->battery_fixed_life_months <= 0) { return null; }
        $used = (int) ($this->battery_actual_usage_months ?? 0);
        return max(0, round((($this->battery_fixed_life_months - $used) / $this->battery_fixed_life_months) * 100, 1));
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
