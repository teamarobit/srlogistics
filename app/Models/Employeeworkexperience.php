<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employeeworkexperience extends Model
{   
    use SoftDeletes;
    
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
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
