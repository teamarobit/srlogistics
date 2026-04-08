<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehiclestatus extends Model
{
    use SoftDeletes;
    
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
    
    // public function xys(){
    //     return $this->hasMany(Xy::class);
    // }
    
    public function isDeletable(){
        // if($this->xys()->count()){
        //     throw new \Exception('You cannot delete as it has child.');
        // }
        
        return true;
    }
}
