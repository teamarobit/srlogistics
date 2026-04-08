<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicledigitallock extends Model
{
    use SoftDeletes;
    
    
    
    // Vehicle
    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'vehicle_id');
    }

    
    public function digitallockprovider()
    {
        return $this->belongsTo(Digitallockprovider::class, 'digitallockprovider_id');
    }
    
    
    public function logs()
    {
        return $this->hasMany(Vehicledigitallocklog::class, 'vehicledigitallock_id');
    }
    
    // public function createdBy()
    // {
    //     return $this->belongsTo(User::class, 'created_by');
    // }
    
    // public function updatedBy()
    // {
    //     return $this->belongsTo(User::class, 'updated_by');
    // }
    
    // public function deletedBy()
    // {
    //     return $this->belongsTo(User::class, 'deleted_by');
    // }
    
    
    
}