<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Insuranceclaim extends Model
{
    use SoftDeletes;

    protected $table = 'insuranceclaims';

    protected $guarded = [];

    protected $casts = [
        'incident_date'      => 'date',
        'claim_filed_date'   => 'date',
        'settlement_date'    => 'date',
        'repair_cost_estimate' => 'decimal:2',
        'amount_claimed'     => 'decimal:2',
        'amount_approved'    => 'decimal:2',
        'amount_received'    => 'decimal:2',
        'excess_payable'     => 'decimal:2',
        'excess_paid'        => 'decimal:2',
    ];

    // ── Relationships ────────────────────────────────────────────────────────

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * The workshop handling repairs for this claim (own or external).
     * FK: workshop_id → workshops.id
     */
    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'workshop_id');
    }

    /**
     * @deprecated  Use workshop() — kept as alias during transition.
     */
    public function externalSc()
    {
        return $this->workshop();
    }

    public function followups()
    {
        return $this->hasMany(Insuranceclaimfollowup::class, 'insuranceclaim_id')->orderBy('event_date', 'desc');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ── Accessors / Helpers ──────────────────────────────────────────────────

    /**
     * Auto-generate next claim number: CLM-YYYY-NNNN
     */
    public static function nextClaimNumber(): string
    {
        $year   = now()->year;
        $prefix = 'CLM-' . $year . '-';
        $last   = static::where('claim_number', 'like', $prefix . '%')
                        ->orderByDesc('claim_number')
                        ->value('claim_number');
        $seq    = $last ? (intval(substr($last, -4)) + 1) : 1;
        return $prefix . str_pad($seq, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Human-readable status colour for badges
     */
    public function statusColour(): string
    {
        return match ($this->status) {
            'Filed'               => 'secondary',
            'Surveyor Assigned'   => 'info',
            'Survey in Progress'  => 'warning',
            'Insurer Approved'    => 'primary',
            'Settlement Received' => 'success',
            'Closed'              => 'dark',
            'Rejected'            => 'danger',
            default               => 'secondary',
        };
    }
}
