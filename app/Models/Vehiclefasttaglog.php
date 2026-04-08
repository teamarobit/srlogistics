<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehiclefasttaglog extends Model
{
    use SoftDeletes;
    
    //protected $table = 'vehiclegps';
    
    public function vehiclefasttag()
    {
        return $this->hasOne(Vehiclefasttags::class, 'vehiclefasttag_id');
    }

    public function fasttagprovider()
    {
        return $this->belongsTo(Fasttagprovider::class, 'fasttagprovider_id');
    }

    // Vehicle
    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'vehicle_id');
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