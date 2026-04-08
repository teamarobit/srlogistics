<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tyrelog extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    
    public function tyre()
    {
        return $this->hasOne(Tyre::class);
    }

    
    // public function createdBy()
    // {
    //     return $this->belongsTo(User::class, 'created_by');
    // }
    
    // public function updatedBy()
    // {
    //     return $this->belongsTo(User::class, 'updated_by');
    // }
    
    // public function deletedBy()
    // {
    //     return $this->belongsTo(User::class, 'deleted_by');
    // }
    
    
    
}