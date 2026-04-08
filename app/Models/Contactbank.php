<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contactbank extends Model
{
    use SoftDeletes;
    
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
