<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loanaccountcrongivenemi extends Model
{
    use SoftDeletes;
    
    public function loanaccount()
    {
        return $this->belongsTo(Loanaccount::class, 'loanaccount_id');
    }
    
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
    
    
    public function financeNotes()
    {
        return $this->hasMany(Emipaymentrecordnote::class, 'loanaccountcrongivenemi_id')->latest();
    }
    
}