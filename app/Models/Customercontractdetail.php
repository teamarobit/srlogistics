<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customercontractdetail extends Model
{
    use SoftDeletes;
    
    public function contract()
    {
        return $this->belongsTo(Customercontract::class, 'customercontract_id');
    }
    
    public function contractType()
    {
        return $this->belongsTo(Contracttype::class, 'contract_type_id');
    }
    
    
    
}
