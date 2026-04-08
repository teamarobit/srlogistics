<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loanaccountlog extends Model
{
    use SoftDeletes;
    
    public function loanaccount()
    {
        return $this->hasOne(Loanaccount::class, 'loanaccount_id');
    }
    
    public function financeprovider()
    {
        return $this->hasOne(Financeprovider::class, 'financeprovider_id', 'id');
    }

    
    
    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    
    
    
}