<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * VehicleInsurancePolicy — per-vehicle insurance policy records.
 *
 * Separate from InsuranceClaim (which tracks accident / damage claims).
 * This tracks the policy itself: number, validity, premium, insurer.
 */
class VehicleInsurancePolicy extends Model
{
    use SoftDeletes;

    protected $table = 'vehicleinsurancepolicies';

    protected $fillable = [
        'vehicle_id',
        'insurancecompany_id',
        'policy_number',
        'policy_type',
        'insured_value',
        'premium_amount',
        'policy_start_date',
        'policy_end_date',
        'status',
        'notes',
        'policy_document',
        'policy_document_name',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'policy_start_date' => 'date',
        'policy_end_date'   => 'date',
        'insured_value'     => 'decimal:2',
        'premium_amount'    => 'decimal:2',
        'deleted_at'        => 'datetime',
    ];

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function scopeExpiringSoon($query, int $days = 30)
    {
        return $query->where('policy_end_date', '>=', now())
                     ->where('policy_end_date', '<=', now()->addDays($days));
    }

    public function scopeExpired($query)
    {
        return $query->where('policy_end_date', '<', now())
                     ->where('status', '!=', 'Cancelled');
    }

    // ─── Relationships ────────────────────────────────────────────────────────

    public function vehicle()
    {
        return $this->belongsTo(Vehiclebasicinfo::class, 'vehicle_id');
    }

    public function insurer()
    {
        return $this->belongsTo(Insurancecompany::class, 'insurancecompany_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    public function daysToExpiry(): ?int
    {
        if (!$this->policy_end_date) return null;
        return (int) now()->startOfDay()->diffInDays($this->policy_end_date->startOfDay(), false);
    }

    public function isExpired(): bool
    {
        return $this->policy_end_date && $this->policy_end_date->isPast();
    }
}
