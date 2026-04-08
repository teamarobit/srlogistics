<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Routetollstation extends Model
{
    use SoftDeletes;
    
    // Relationships
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }
    
    public function tollstation()
    {
        return $this->belongsTo(Tollstation::class, 'tollstation_id');
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
