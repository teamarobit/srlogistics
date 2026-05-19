<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'trip_id',
        'organisation_id',
        'trip_date',
        'trip_type',
        'trip_category',
        'load_vendor_id',
        'rag_status',
        'customer_id',
        'vehicletype_id',
        'vehicletypesize_id',
        'vehicle_id',
        'internal_trip_id',
        'route_id',
        'source',
        'destination',
        'midpoint',
        'distance',
        'lr_date',
        'lr_number',
        'priority',
        'tarpaulin',
        'trip_status',
        'payment_status',
        'pod_remarks',
        'comment',
        'created_by',
        'updated_by',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function loadVendor()
    {
        return $this->belongsTo(Contact::class, 'load_vendor_id');
    }

    public function customer()
    {
        return $this->belongsTo(Contact::class, 'customer_id');
    }

    public function vehicleType()
    {
        return $this->belongsTo(Vehicletype::class, 'vehicletype_id');
    }

    public function vehicleSize()
    {
        return $this->belongsTo(Vehicletypesize::class, 'vehicletypesize_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function route()
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }

    // ── Auto-generate trip_id ─────────────────────────────────────────────────

    public static function nextCode(): string
    {
        $last = static::withTrashed()->orderByDesc('id')->value('trip_id');

        if (! $last) {
            return 'TRIP0001';
        }

        $num = (int) preg_replace('/\D/', '', $last);
        return 'TRIP' . str_pad($num + 1, 4, '0', STR_PAD_LEFT);
    }
}
