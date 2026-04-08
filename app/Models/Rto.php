<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rto extends Model
{
    use SoftDeletes;
    
    public function routes()
    {
        return $this->belongsToMany(
            Route::class,
            'routertos'
        )->withTimestamps()->withPivot('deleted_at');
    }
    
    public function routertos()
    {
        return $this->hasMany(Routerto::class, 'rto_id');
    }
    
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
