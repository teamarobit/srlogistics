<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assetfile extends Model
{
    use SoftDeletes;
    
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
