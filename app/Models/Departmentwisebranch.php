<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departmentwisebranch extends Model
{
    use SoftDeletes;
    
    public function departments()
    {
        return $this->hasMany(Department::class, 'department_id');
    }
    
    
    
    
}