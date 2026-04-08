<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    public function states()
    {
        return $this->hasMany(State::class);
    }
    
    public function taxationtypes(){
        /** currenty we are maintaining a country has only one taxation. 
         * But we have the provision to set multiple taxationtypes(future scope, will have have to work on for this)
         * That's why we are writing hasMany relation.
        */
        return $this->hasMany(Taxationtype::class);
    }
}
