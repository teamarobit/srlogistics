<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contractpricinglocationpointlog extends Model
{
    use SoftDeletes;
    
    public function contractPricingLog()
    {
        return $this->belongsTo(Contractpricinglog::class, 'contractpricinglog_id');
    }

    public function location()
    {
        return $this->belongsTo(Customerlocation::class, 'customerlocation_id');
    }
}