<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trackingvehicle extends Model
{
    use SoftDeletes;
    
    public function vehicleGroupTracking()
    {
        return $this->belongsTo(Vehiclegrouptracking::class, 'vehiclegrouptracking_id');
    }
    
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
    
    
}