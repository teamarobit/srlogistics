<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * An uploaded client sign-off document attached to a PpModule. Stored outside
 * the public web root; served only through the auth-checked download route.
 */
class PpModuleFile extends Model
{
    use SoftDeletes;

    protected $table = 'pp_module_files';

    protected $fillable = [
        'pp_module_id',
        'original_name',
        'stored_path',
        'mime_type',
        'size_bytes',
        'uploaded_by',
    ];

    protected $casts = [
        'size_bytes' => 'integer',
    ];

    public function module()
    {
        return $this->belongsTo(PpModule::class, 'pp_module_id');
    }
}
