<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contractpricinglog extends Model
{
    use SoftDeletes;
    
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function customerContract()
    {
        return $this->belongsTo(Customercontract::class, 'customercontract_id');
    }

    public function route()
    {
        return $this->belongsTo(Contractroute::class, 'customercontract_route_id');
    }
    
    public function vehicles()
    {
        return $this->hasMany(Contractpricingvehicle::class, 'contractpricing_id');
    }
    
    
    public function vehicleLogs()
    {
        return $this->hasMany(Contractpricingvehiclelog::class, 'contractpricinglog_id');
    }
    
    public function locationLogs()
    {
        return $this->hasMany(Contractpricinglocationpointlog::class, 'contractpricinglog_id');
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