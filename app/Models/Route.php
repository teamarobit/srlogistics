<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Route extends Model
{
    use SoftDeletes;
    
    public function sourceState() {
        return $this->belongsTo(State::class, 'source_state_id');
    }

    public function sourceCity() {
        return $this->belongsTo(City::class, 'source_city_id');
    }

    public function destinationState() {
        return $this->belongsTo(State::class, 'destination_state_id');
    }

    public function destinationCity() {
        return $this->belongsTo(City::class, 'destination_city_id');
    }
    
    public function tollstations()
    {
        return $this->hasMany(Routetollstation::class, 'route_id');
    }
    
    public function rtos()
    {
        return $this->hasMany(Routerto::class, 'route_id');
    }
    
    public function midpoints()
    {
        return $this->hasMany(Routemidpoint::class);
    }
    
    public function customercontracts()
    {
        return $this->belongsToMany(
            Customercontract::class,
            'contractroutes',
            'route_id',
            'customercontract_id'
        );
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
