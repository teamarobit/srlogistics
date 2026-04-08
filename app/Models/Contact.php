<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    
    public function cotype()
    {
        return $this->belongsTo(Cotype::class);
    }
    
    // public function roles()
    // {
    //     return $this->hasMany(Contactrole::class);
    // }
    
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'contactroles')
                    ->withTimestamps()
                    ->withPivot('deleted_at');
    }
    
    public function cobilling()
    {
        return $this->hasOne(Cobilling::class);
    }
    
    public function coshippings()
    {
        return $this->hasMany(Coshipping::class, 'contact_id')->latest();
    }
    
    public function gsttreat()
    {
        return $this->belongsTo(Gsttreat::class);
    }
    
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    
    
    
    
    
    
    // Office Branch
    public function officeBranch()
    {
        return $this->belongsTo(Branch::class, 'office_branch_id');
    }
    public function officeDepartment()
    {
        return $this->belongsTo(Department::class, 'office_department_id');
    }
    public function officeDesignation()
    {
        return $this->belongsTo(Designation::class, 'office_designation_id');
    }
    
    
    

    // Service Center Branch
    public function serviceCenterBranch()
    {
        return $this->belongsTo(Branch::class, 'service_center_branch_id');
    }
    public function serviceCenterDepartment()
    {
        return $this->belongsTo(Department::class, 'service_center_department_id');
    }
    public function serviceCenterDesignation()
    {
        return $this->belongsTo(Designation::class, 'service_center_designation_id');
    }
    
    
    
    // Contract Pricing
    public function contractPricings()
    {
        return $this->hasMany(Contractpricing::class, 'contact_id')->latest();
    }
    
    
    
    
    public function coaddresses()
    {
        return $this->hasMany(Coaddress::class)->latest();
    }
    
    public function bank()
    {
        return $this->hasOne(Contactbank::class, 'contact_id');
    }
    
    public function relcontacts()
    {
        return $this->hasMany(Relcontact::class, 'contact_id');
    }
    
    public function coattachments()
    {
        return $this->hasMany(Coattachment::class)->latest();
    }
    
    public function abouttype()
    {
        return $this->belongsTo(Customerabouttype::class, 'about_type_id');
    }
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
    
    public function customerlocations()
    {
        return $this->hasMany(Customerlocation::class, 'contact_id')->latest();
    }
    
    public function customercontracts()
    {
        return $this->hasMany(Customercontract::class, 'contact_id')->latest();
    }
    
    public function activities()
    {
        return $this->hasMany(Contactactivity::class, 'contact_id')->latest();
    }
    
    
    
    public function employeeAssets()
    {
        return $this->hasMany(Employeeasset::class, 'contact_id')->latest();
    }
    public function assetLogs()
    {
        return $this->hasMany(Employeeallotedassetlog::class, 'contact_id')->latest();
    }
    
    
    
    public function workExperiences()
    {
        return $this->hasMany(Employeeworkexperience::class, 'contact_id')->orderBy('employment_end_date', 'desc');
    }
    
    
    public function salaries()
    {
        return $this->hasMany(Employeesalary::class, 'contact_id')->latest();
    }
    
    
    public function employeeExitDetail()
    {
        return $this->hasOne(Employeeexitdetail::class, 'contact_id');
    }
    
    
    public function loadvendorlocations()
    {
        return $this->hasMany(Loadvendorlocation::class, 'contact_id')->latest();
    }
    
    
    public function bankDetails()
    {
        return $this->hasMany(Contactbank::class, 'contact_id')->latest();
    }
    
    
    public function driverinfo()
    {
        return $this->hasOne(Driverinfo::class, 'contact_id');
    }
    
    public function driverVehiclePhotos()
    {
        return $this->hasMany(Drivervehiclephoto::class, 'contact_id')->latest();
    }
    
    public function vehicles()
    {
        return $this->belongsToMany(
            Vehicle::class,
            'vehicleallocations',
            'contact_id',
            'vehicle_id'
        );
    }
    
    public function vehicleAllocations()
    {
        return $this->hasMany(Vehicleallocation::class, 'contact_id');
    }
    
    public function currentVehicleAllocation()
    {
        return $this->hasOne(Vehicleallocation::class, 'contact_id')->latestOfMany();
    }
    
    
    
    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }
    
    
    
    
    public function createdby()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function updatedby()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
    public function deletedby()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    
}
