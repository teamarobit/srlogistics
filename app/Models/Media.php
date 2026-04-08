<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;
    
    protected $table = 'medias';
    
    protected $guarded = [];
    
    public function mediable()
    {
        return $this->morphTo();
    }
    
    public function mediadocument(){
        return $this->belongsTo(Mediadocument::class);
    }
    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
}
