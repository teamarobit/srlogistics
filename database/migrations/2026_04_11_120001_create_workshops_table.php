<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Unified workshops table.
 *
 * Consolidates the former servicecentres (Own) and externalservicecentres (External)
 * tables into a single entity. The `ownership` column differentiates them.
 * BA CIAA approved — April 2026.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workshops', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('organisation_id')->nullable()->comment('FK → organisations.id');

            $table->string('workshop_code')->unique()->comment('e.g. WS-HYD-001, WS-EXT-001');
            $table->string('name');

            // ── Ownership & Type ───────────────────────────────────────────────
            $table->enum('ownership', ['Own', 'External'])->default('Own')
                  ->comment('Own = company workshop; External = 3rd party / ASC');

            $table->enum('workshop_type', [
                'Workshop',
                'Mobile Unit',
                'Hybrid',
                'Brand ASC',
                'Third Party',
                'Warranty',
                'Multi-Brand',
            ])->default('Workshop');

            $table->string('brand')->nullable()
                  ->comment('Vehicle brand serviced — relevant for Brand ASC / Warranty');

            // ── Location ───────────────────────────────────────────────────────
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->text('address')->nullable();
            $table->string('pincode', 10)->nullable();

            // ── Contacts ───────────────────────────────────────────────────────
            $table->string('manager_name')->nullable()
                  ->comment('Own workshop manager / External workshop contact person');
            $table->string('contact_phone', 20)->nullable();
            $table->string('contact_email')->nullable();

            // ── Own-workshop extras ────────────────────────────────────────────
            $table->integer('technician_count')->default(0)
                  ->comment('Relevant for Own workshops');

            $table->text('notes')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');

            // ── Audit ──────────────────────────────────────────────────────────
            $table->bigInteger('created_by')->nullable()->comment('FK → users.id');
            $table->bigInteger('updated_by')->nullable()->comment('FK → users.id');
            $table->bigInteger('deleted_by')->nullable()->comment('FK → users.id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workshops');
    }
};
