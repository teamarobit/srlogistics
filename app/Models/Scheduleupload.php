<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scheduleupload extends Model
{
    use SoftDeletes;
    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    
}