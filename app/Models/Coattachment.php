<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coattachment extends Model
{
    use SoftDeletes;
    
    public function coattachtype()
    {
        return $this->belongsTo(Coattachtype::class);
    }
    
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    
    public function createdby()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function updatedby()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
    public function deletedby()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    
   
}
