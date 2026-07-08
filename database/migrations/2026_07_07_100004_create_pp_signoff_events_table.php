<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * pp_signoff_events — immutable audit trail of who did what and when on the
 * Project Progress board (status changes, approvals, freezes, file activity).
 * No soft deletes: this is an append-only log.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pp_signoff_events', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('pp_phase_id')->nullable();
            $table->bigInteger('pp_module_id')->nullable();
            $table->enum('event_type', [
                'Status Changed',
                'Client Approved',
                'Approval Removed',
                'Module Frozen',
                'Phase Frozen',
                'File Uploaded',
                'File Removed',
            ]);
            $table->bigInteger('performed_by')->nullable();
            $table->json('meta')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->index('pp_module_id');
            $table->index('pp_phase_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pp_signoff_events');
    }
};
