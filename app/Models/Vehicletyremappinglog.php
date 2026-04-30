<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicletyremappinglog extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    
    public function vehicletyremapping()
    {
        return $this->belongsTo(Vehicletyremapping::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function tyreposition()
    {
        return $this->belongsTo(Tyreposition::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Polymorphic media attachments for this log entry.
     * Images uploaded at the time of tyre fitment / removal.
     */
    public function medias()
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    public function images()
    {
        return $this->morphMany(Media::class, 'mediable')->where('type', 'Image');
    }



}