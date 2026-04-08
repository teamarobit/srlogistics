<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;
    
    public function departments()
    {
        return $this->belongsToMany(
            Department::class,
            'departmentwisebranches',
            'branch_id',
            'department_id'
        )->withTimestamps();
    }
    
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    
    public function files()
    {
        // Assuming your model name is Branchfile and table is branchfiles
        return $this->hasMany(Branchfile::class, 'branch_id');
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
