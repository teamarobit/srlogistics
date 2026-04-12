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
        'last_done_date',
        'next_due_date',
        'odometer_km',
        'status',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'last_done_date' => 'date',
        'next_due_date'  => 'date',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function tyre()
    {
        return $this->belongsTo(Tyre::class, 'tyre_id');
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
