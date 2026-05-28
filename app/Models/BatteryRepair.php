<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatteryRepair extends Model
{
    use SoftDeletes;

    protected $table = 'batteryrepairs';

    protected $guarded = [];

    protected $casts = [
        'repair_date' => 'date',
        'cost'        => 'decimal:2',
    ];

    public function battery()
    {
        return $this->belongsTo(Battery::class, 'battery_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Contact::class, 'vendor_id');
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
