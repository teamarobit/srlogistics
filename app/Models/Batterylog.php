<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Batterylog extends Model
{
    use SoftDeletes;

    protected $table = 'batterylogs';

    protected $guarded = [];

    public function battery()
    {
        return $this->belongsTo(Battery::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function medias()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
