<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Actmodel extends Model
{
    use SoftDeletes;
    
    
    // Parent
    public function parent()
    {
        return $this->belongsTo(Actmodel::class, 'parent_id');
    }

    // Children
    public function children()
    {
        return $this->hasMany(Actmodel::class, 'parent_id');
    }
}