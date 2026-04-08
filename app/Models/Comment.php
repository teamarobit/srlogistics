<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function commentable()
    {
        return $this->morphTo();
    }
    
    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
