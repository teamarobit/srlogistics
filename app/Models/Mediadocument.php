<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mediadocument extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    
    public function medias()
    {
        return $this->hasMany(Media::class);
    }
    
    public function attachmenttype(){
        return $this->belongsTo(Attachmenttype::class);
    }
}
