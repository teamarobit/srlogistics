<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contractpricingvehicle extends Model
{
    use SoftDeletes;
    
    public function contractPricing()
    {
        return $this->belongsTo(Contractpricing::class, 'contractpricing_id');
    }

    public function vehicleType()
    {
        return $this->belongsTo(Vehicletype::class, 'vehicletype_id');
    }

    public function vehicleTypeSize()
    {
        return $this->belongsTo(Vehicletypesize::class, 'vehicletypesize_id');
    }
}
