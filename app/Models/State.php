<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    protected $guarded = [];
    
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    
    public function cities()
    {
        return $this->hasMany(City::class);
    }
    
    public function useractivities()
    {
        return $this->morphMany(Useractivity::class, 'useractivitiable');
    }
}
