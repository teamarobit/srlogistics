<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organisationuser extends Model
{
    use SoftDeletes;
    
    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
