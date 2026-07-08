<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Append-only audit record for the Project Progress board: captures who
 * performed each status change, approval, freeze or file action, and when.
 * No SoftDeletes — this log is never deleted.
 */
class PpSignoffEvent extends Model
{
    protected $table = 'pp_signoff_events';

    protected $fillable = [
        'pp_phase_id',
        'pp_module_id',
        'event_type',
        'performed_by',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function module()
    {
        return $this->belongsTo(PpModule::class, 'pp_module_id');
    }

    public function phase()
    {
        return $this->belongsTo(PpPhase::class, 'pp_phase_id');
    }
}
