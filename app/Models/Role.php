<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    
    // public function contacts()
    // {
    //     return $this->belongsToMany(Contact::class, 'contactroles');
    // }
    
    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contactroles')
                    ->withTimestamps()
                    ->withPivot('deleted_at');
    }
    
    
    
    
}