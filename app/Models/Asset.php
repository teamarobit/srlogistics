<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use SoftDeletes;
    
    public function files()
    {
        return $this->hasMany(Assetfile::class, 'asset_id');
    }
    
    public function employeeAssets()
    {
        return $this->hasMany(Employeeasset::class, 'asset_id');
    }
    
    public function activeEmployeeAsset()
    {
        return $this->hasOne(Employeeasset::class, 'asset_id')->where('status', 'Assigned')->whereNull('revoke_date');
    }
    
    public function assetLogs()
    {
        return $this->hasMany(Employeepallotedassetlog::class, 'asset_id');
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