<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehiclefasttags extends Model
{
    use SoftDeletes;
    
    //protected $table = 'vehiclegps';
    

    // Vehicle
    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'vehicle_id');
    }

    public function fasttagprovider()
    {
        return $this->belongsTo(Fasttagprovider::class, 'fasttagprovider_id');
    }
    
    public function logs()
    {
        return $this->hasMany(Vehiclefasttaglog::class, 'vehiclefasttag_id');
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