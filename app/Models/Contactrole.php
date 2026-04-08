<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contactrole extends Model
{
    use SoftDeletes;
    
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
