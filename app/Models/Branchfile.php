<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branchfile extends Model
{
    use SoftDeletes;
    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
