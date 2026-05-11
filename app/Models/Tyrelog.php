<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tyrelog extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    // ── Tyre this log belongs to ──────────────────────────────────────────
    public function tyre()
    {
        return $this->belongsTo(Tyre::class);
    }

    // ── Vehicle this action was performed on (nullable FK) ────────────────
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    // ── User who created this log entry ───────────────────────────────────
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ── Polymorphic media attachments (invoices, photos) ─────────────────
    // mediable_type = App\Models\Tyrelog, mediable_id = tyrelog.id
    public function medias()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}