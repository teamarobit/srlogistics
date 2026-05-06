<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TyreRepair extends Model
{
    use SoftDeletes;

    protected $table = 'tyrerepairs';

    protected $guarded = [];

    protected $casts = [
        'repair_date' => 'date',
        'cost'        => 'decimal:2',
    ];

    public function tyre()
    {
        return $this->belongsTo(Tyre::class, 'tyre_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function tyreposition()
    {
        return $this->belongsTo(Tyreposition::class, 'tyreposition_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Contact::class, 'vendor_id');
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
