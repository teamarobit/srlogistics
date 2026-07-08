<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * pp_modules — one row per module inside a phase, plus its sign-off state
 * (status, client approval, freeze lock, notes). module_key is a stable slug
 * used as the persistence key (replaces the old positional data-module index).
 *
 * pp_phase_id is a signed bigInteger with NO FK constraint (MySQL 8 signed/
 * unsigned mismatch — CLAUDE.md). Integrity is enforced via exists: validation.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pp_modules', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('pp_phase_id');
            $table->string('module_key');
            $table->string('group_name')->nullable();
            $table->string('name');
            $table->integer('sort_order')->default(0);
            $table->enum('status', ['Not Started', 'In Design', 'Design Done', 'Approved'])
                  ->default('Not Started');
            $table->boolean('client_approved')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->bigInteger('approved_by')->nullable();
            $table->boolean('is_frozen')->default(false);
            $table->timestamp('frozen_at')->nullable();
            $table->bigInteger('frozen_by')->nullable();
            $table->text('notes')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();

            $table->index('pp_phase_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pp_modules');
    }
};
