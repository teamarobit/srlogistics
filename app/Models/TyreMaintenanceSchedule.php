<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TyreMaintenanceSchedule extends Model
{
    use SoftDeletes;

    protected $table = 'tyremaintenanceschedules';

    protected $fillable = [
        'tyre_id',
        'maintenance_item',
        'maintenance_type',
        'vehicle_id',
        'last_done_date',
        'next_due_date',
        'odometer_km',
        'scheduled_km',
        'actual_km',
        'cost',
        'status',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'last_done_date' => 'date',
        'next_due_date'  => 'date',
        'cost'           => 'decimal:2',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function tyre()
    {
        return $this->belongsTo(Tyre::class, 'tyre_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
