<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Designation extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];
    
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    
    public function jobranks()
    {
        return $this->hasMany(Jobrank::class, 'designation_id');
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