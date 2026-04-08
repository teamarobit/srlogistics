<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contractpricinglocationpoint extends Model
{
    use SoftDeletes;
    
    public function contractPricing()
    {
        return $this->belongsTo(Contractpricing::class, 'contractpricing_id');
    }

    public function location()
    {
        return $this->belongsTo(Customerlocation::class, 'customerlocation_id');
    }
}