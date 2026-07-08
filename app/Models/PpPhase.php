<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * A Project Progress phase (1–11). Holds phase-level freeze state and owns
 * the modules rendered inside it.
 */
class PpPhase extends Model
{
    use SoftDeletes;

    protected $table = 'pp_phases';

    protected $fillable = [
        'phase_no',
        'title',
        'color',
        'sort_order',
        'is_frozen',
        'frozen_at',
        'frozen_by',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_frozen' => 'boolean',
        'frozen_at' => 'datetime',
    ];

    // ─── Relationships ───────────────────────────────────────────────────────

    public function modules()
    {
        return $this->hasMany(PpModule::class, 'pp_phase_id')->orderBy('sort_order');
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    /** Weighted design-progress percentage across this phase's modules. */
    public function progress(): int
    {
        $modules = $this->relationLoaded('modules') ? $this->modules : $this->modules()->get();
        $total   = $modules->count();
        if (! $total) {
            return 0;
        }

        $weights = ['Not Started' => 0, 'In Design' => 34, 'Design Done' => 67, 'Approved' => 100];
        $sum     = $modules->sum(fn ($m) => $weights[$m->status] ?? 0);

        return (int) round($sum / $total);
    }
}
