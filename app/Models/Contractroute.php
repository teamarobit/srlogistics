<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contractroute extends Model
{
    use SoftDeletes;
    
    public function customercontract()
    {
        return $this->belongsTo(Customercontract::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
    
    public function contractPricings()
    {
        return $this->hasMany(Contractpricing::class, 'customercontract_route_id');
    }
}
