<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Routemidpoint extends Model
{
    use SoftDeletes;
    
    
    
    public function route()
    {
        return $this->belongsTo(Route::class);
    }
    
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    
    
    
    
}
