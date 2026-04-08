<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Routerto extends Model
{
    use SoftDeletes;
    
    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function rto()
    {
        return $this->belongsTo(Rto::class, 'rto_id');
    }
}
