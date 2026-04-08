<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehiclegpslog extends Model
{
    use SoftDeletes;
    
    protected $table = 'vehiclegpslogs';
    
    
    public function vehiclegps()
    {
        return $this->belongsTo(Vehiclegps::class, 'vehiclegps_id');
    }
    
    public function gpsprovider()
    {
        return $this->belongsTo(Gpsprovider::class, 'gpsprovider_id');
    }
    
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
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