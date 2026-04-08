<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicletypesize extends Model
{
    use SoftDeletes;
    
    public function vehicleType()
    {
        return $this->belongsTo(Vehicletype::class, 'vehicletype_id');
    }
    
}
