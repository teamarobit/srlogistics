<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehiclebatterylog extends Model
{
    use SoftDeletes;

    protected $table = 'vehiclebatterylogs';

    protected $guarded = [];

    protected $casts = [
        'purchase_date' => 'date',
        'fitment_date'  => 'date',
        'issue_date'    => 'date',
    ];

    // ── Relationships ────────────────────────────────────────────────────

    public function vehiclebattery()
    {
        return $this->belongsTo(Vehiclebattery::class, 'vehiclebattery_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
