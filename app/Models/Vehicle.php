<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;
    
    public function basicinfo()
    {
        return $this->hasOne(Vehiclebasicinfo::class, 'vehicle_id', 'id');
    }
    
    
    public function ownership()
    {
        return $this->belongsTo(Vehicleownership::class, 'vehicleownership_id');
    }

    public function group()
    {
        return $this->belongsTo(Vehiclegroup::class, 'vehiclegroup_id');
    }

    public function type()
    {
        return $this->belongsTo(Vehicletype::class, 'vehicletype_id');
    }

    public function size()
    {
        return $this->belongsTo(Vehicletypesize::class, 'vehicletypesize_id');
    }
    
    public function vehicleAllocations()
    {
        return $this->hasMany(VehicleAllocation::class, 'vehicle_id')->latest();
    }

    public function contacts()
    {
        return $this->belongsToMany(
            Contact::class,
            'vehicleallocations',
            'vehicle_id',
            'contact_id'
        );
    }
    
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
    
    public function driverAllocation()
    {
        return $this->hasOne(Vehicleallocation::class, 'vehicle_id')->where('type', 'Driver')->whereNull('deleted_at');
    }
    
    public function customerAllocation()
    {
        return $this->hasOne(Vehicleallocation::class, 'vehicle_id')->where('type', 'Customer')->whereNull('deleted_at');
    }
    
    public function groupTracking()
    {
        return $this->hasOne(Vehiclegrouptracking::class, 'vehicle_group_id', 'vehiclegroup_id')->whereNull('deleted_at');
    }
    
    public function gps()
    {
        return $this->hasMany(Vehiclegps::class, 'vehicle_id')->latest();
    }
    
    public function fasttag()
    {
        return $this->hasOne(Vehiclefasttags::class, 'vehicle_id');
    }
    
    public function vehicletyremappings()
    {
        return $this->hasMany(Vehicletyremapping::class, 'vehicle_id');
    }
    
    public function batteries()
    {
        return $this->hasMany(Vehiclebattery::class, 'vehicle_id')->latest();
    }
    
    public function digitalLocks()
    {
        return $this->hasMany(Vehicledigitallock::class, 'vehicle_id')->latest();
    }
    
    public function loanaccounts()
    {
        return $this->hasMany(Loanaccount::class, 'vehicle_id')->latest();
    }
    
    public function chassisLoanAccounts()
    {
        return $this->hasMany(Loanaccount::class, 'vehicle_id')->where('type', 'Chassis');
    }
    
    public function bodyLoanAccounts()
    {
        return $this->hasMany(Loanaccount::class, 'vehicle_id')->where('type', 'Body');
    }
    
    public function cronGivenEMIs()
    {
        return $this->hasMany(Loanaccountcrongivenemi::class, 'vehicle_id')->latest();
    }
    
    public function chassisEmis()
    {
        return $this->hasMany(Loanaccountcrongivenemi::class, 'vehicle_id')
                            ->whereHas('loanaccount', function ($q) {
                                $q->where('type', 'Chassis');
                            });
    }
    
    public function bodyEmis()
    {
        return $this->hasMany(Loanaccountcrongivenemi::class, 'vehicle_id')
                            ->whereHas('loanaccount', function ($q) {
                                $q->where('type', 'Body');
                            });
    }
    
    public function vehicletyres(){
        return $this->hasMany(Vehicletyre::class);
    }
    
    public function medias()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
    
    public function images(){
        return $this->morphMany(Media::class, 'mediable')->where('type', 'Image');
    }
    
    public function documents(){
        return $this->morphMany(Media::class, 'mediable')->where('type', 'Document');
    }
    
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    
    
    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
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
