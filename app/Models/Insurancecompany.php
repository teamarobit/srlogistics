<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Insurancecompany — lookup table for vehicle insurance providers.
 * Follows the same pattern as Fasttagprovider / Gpsprovider.
 */
class Insurancecompany extends Model
{
    use SoftDeletes;

    protected $table = 'insurancecompanies';

    protected $fillable = [
        'name',
        'code',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function policies()
    {
        return $this->hasMany(VehicleInsurancePolicy::class, 'insurancecompany_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
