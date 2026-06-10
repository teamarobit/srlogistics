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

    /**
     * Contracts that still bind this route (block editing).
     * A contract releases the route only once it has EXPIRED
     * (end_date in the past). Soft-deleted contracts are already
     * excluded by the SoftDeletes scope on Customercontract.
     */
    public function activeCustomercontracts()
    {
        return $this->customercontracts()
            ->where(function ($q) {
                $q->whereNull('customercontracts.end_date')
                  ->orWhereDate('customercontracts.end_date', '>=', now()->toDateString());
            });
    }

    /**
     * True when at least one non-expired contract is attached,
     * meaning the route must not be edited.
     */
    public function isLockedByContract(): bool
    {
        return $this->activeCustomercontracts()->exists();
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
