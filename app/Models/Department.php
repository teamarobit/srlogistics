<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];
    
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    
    public function branches()
    {
        return $this->belongsToMany(
            Branch::class,
            'departmentwisebranches', // pivot table
            'department_id',          // FK in pivot for this model
            'branch_id'               // FK in pivot for related model
        )->withTimestamps();
    }
    
    // public function branch()
    // {
    //     return $this->belongsTo(Branch::class, 'branch_id');
    // }
    
    public function designations()
    {
        return $this->hasMany(Designation::class, 'department_id');
    }
    
    public function jobranks()
    {
        return $this->hasMany(Jobrank::class, 'department_id');
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
