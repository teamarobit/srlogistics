<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loadvendorlocation extends Model
{
    use SoftDeletes;
    
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    
    public function sourceCity()
    {
        return $this->belongsTo(City::class, 'source_city_id');
    }

    public function destinationCity()
    {
        return $this->belongsTo(City::class, 'destination_city_id');
    }

    public function midpointCity()
    {
        return $this->belongsTo(City::class, 'midpoint_city_id');
    }
    
    

    // public function state()
    // {
    //     return $this->belongsTo(State::class);
    // }

    // public function city()
    // {
    //     return $this->belongsTo(City::class);
    // }
    
    
    
    
    
    
}