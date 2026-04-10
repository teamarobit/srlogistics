<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicletyremapping extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    
    public function vehicletyremappinglogs()
    {
        return $this->hasMany(Vehicletyremappinglog::class);
    }
    
    public function tyreposition(){
        return $this->belongsTo(Tyreposition::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    
    
}