<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customercontract extends Model
{
    use SoftDeletes;
    
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    
    public function contracttype()
    {
        return $this->belongsTo(Contracttype::class, 'contract_type_id');
    }
    
    public function detail()
    {
        return $this->hasOne(Customercontractdetail::class, 'customercontract_id');
    }
    
    
    public function routes()
    {
        return $this->belongsToMany(
            Route::class,
            'contractroutes',
            'customercontract_id',
            'route_id'
        );
    }
    
    
    public function contractPricings()
    {
        return $this->hasMany(Contractpricing::class, 'customercontract_id');
    }
    
    
}
