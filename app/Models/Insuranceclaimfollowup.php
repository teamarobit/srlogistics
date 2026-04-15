<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Insuranceclaimfollowup extends Model
{
    use SoftDeletes;

    protected $table = 'insuranceclaimfollowups';

    protected $guarded = [];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function claim()
    {
        return $this->belongsTo(Insuranceclaim::class, 'insuranceclaim_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
