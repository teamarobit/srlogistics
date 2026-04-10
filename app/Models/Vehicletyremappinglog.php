<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicletyremappinglog extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    
    public function vehicletyremapping()
    {
        return $this->belongsTo(Vehicletyremapping::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    
    
}