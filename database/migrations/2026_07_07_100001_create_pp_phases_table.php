<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * pp_phases — the 11 workflow phases for the Project Progress board.
 * Replaces the previously-hardcoded phases() array with real data.
 * Signed bigInteger PK per project convention (no $table->id()).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pp_phases', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('phase_no');
            $table->string('title');
            $table->string('color', 20);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_frozen')->default(false);
            $table->timestamp('frozen_at')->nullable();
            $table->bigInteger('frozen_by')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pp_phases');
    }
};
