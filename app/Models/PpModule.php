<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * A single module within a Project Progress phase. Carries its own sign-off
 * state: design status, client approval, freeze lock and free-text notes.
 * Owns many uploaded sign-off files.
 */
class PpModule extends Model
{
    use SoftDeletes;

    protected $table = 'pp_modules';

    protected $fillable = [
        'pp_phase_id',
        'module_key',
        'group_name',
        'name',
        'sort_order',
        'status',
        'client_approved',
        'approved_at',
        'approved_by',
        'is_frozen',
        'frozen_at',
        'frozen_by',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'client_approved' => 'boolean',
        'is_frozen'       => 'boolean',
        'approved_at'     => 'datetime',
        'frozen_at'       => 'datetime',
    ];

    /** Allowed design lifecycle statuses (ENUM, Title Case). */
    public const STATUSES = ['Not Started', 'In Design', 'Design Done', 'Approved'];

    // ─── Relationships ───────────────────────────────────────────────────────

    public function phase()
    {
        return $this->belongsTo(PpPhase::class, 'pp_phase_id');
    }

    public function files()
    {
        return $this->hasMany(PpModuleFile::class, 'pp_module_id')->latest('id');
    }

    public function events()
    {
        return $this->hasMany(PpSignoffEvent::class, 'pp_module_id')->latest('id');
    }
}
