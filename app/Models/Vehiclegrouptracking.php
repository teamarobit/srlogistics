<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehiclegrouptracking extends Model
{
    use SoftDeletes;
    
    public function vehicleGroup()
    {
        return $this->belongsTo(Vehiclegroup::class, 'vehicle_group_id');
    }
    
    public function vehicles()
    {
        return $this->hasMany(Trackingvehicle::class, 'vehiclegrouptracking_id');
    }
    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}