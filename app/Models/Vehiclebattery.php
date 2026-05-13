<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehiclebattery extends Model
{
    use SoftDeletes;

    protected $table = 'vehiclebatteries';

    protected $guarded = [];

    protected $casts = [
        'purchase_date'  => 'date',
        'fitment_date'   => 'date',
        'issue_date'     => 'date',
        'battery_price'  => 'decimal:2',
    ];

    // ── Relationships ────────────────────────────────────────────────────

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function logs()
    {
        return $this->hasMany(Vehiclebatterylog::class, 'vehiclebattery_id');
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

    // ── Computed: warranty remaining months ──────────────────────────────

    public function getWarrantyRemainingMonthsAttribute(): ?int
    {
        if (!$this->purchase_date || !$this->warranty_months) {
            return null;
        }
        $expiryDate = \Carbon\Carbon::parse($this->purchase_date)->addMonths($this->warranty_months);
        $remaining  = (int) now()->diffInMonths($expiryDate, false);
        return max(0, $remaining);
    }

    // ── Computed: life remaining months ─────────────────────────────────

    public function getLifeRemainingMonthsAttribute(): ?int
    {
        if (!$this->battery_life_fixed) {
            return null;
        }
        $used = (int) ($this->battery_actual_run_months ?? 0);
        return max(0, $this->battery_life_fixed - $used);
    }

    // ── Computed: life remaining % ───────────────────────────────────────

    public function getLifeRemainingPctAttribute(): ?float
    {
        if (!$this->battery_life_fixed || $this->battery_life_fixed <= 0) {
            return null;
        }
        $used = (int) ($this->battery_actual_run_months ?? 0);
        return max(0, round((($this->battery_life_fixed - $used) / $this->battery_life_fixed) * 100, 1));
    }

    // ── Scopes ────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function scopeForVehicle($query, $vehicleId)
    {
        return $query->where('vehicle_id', $vehicleId);
    }
}
