<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * pp_module_files — uploaded client sign-off documents. A module can have
 * MANY files (PpModule hasMany PpModuleFile). Files are stored outside the
 * public web root and served through an auth-checked download route.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pp_module_files', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('pp_module_id');
            $table->string('original_name');
            $table->string('stored_path');
            $table->string('mime_type', 150)->nullable();
            $table->bigInteger('size_bytes')->nullable();
            $table->bigInteger('uploaded_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();

            $table->index('pp_module_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pp_module_files');
    }
};
