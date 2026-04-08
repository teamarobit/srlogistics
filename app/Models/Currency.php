<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes;
    
    
    public function tollStations()
    {
        return $this->hasMany(TollStation::class, 'currency_id');
    }
    
    
}