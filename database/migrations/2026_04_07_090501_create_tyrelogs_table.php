<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tyrelogs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->enum('location', ['Warehouse', 'Vehicle', 'Service Center'])->default('Warehouse');
            $table->bigInteger('warehouse_id')->nullable();
            $table->bigInteger('tyre_id')->comment('FK → tyres.id');
            $table->bigInteger('contact_id')->comment('FK → contacts.id | Tyre Vendor	');
            $table->enum('tyre_condition', ['New', 'Re-thread', 'Discard']);
            $table->string('tyre_model');
            $table->enum('tyre_type', ['Radial', 'Nylon'])->nullable();
            $table->string('tyre_brand')->nullable();
            $table->double('tyre_price')->default(0);
            $table->string('tyre_serial_number')->nullable();
            $table->date('tyre_purchase_date')->nullable();
            $table->date('tyre_issue_date')->nullable();
            $table->integer('tyre_warranty_months')->nullable();
            $table->date('tyre_warrenty_end_date')->nullable();
            $table->decimal('fixed_run_km', 10)->nullable();
            $table->integer('fixed_life_months')->nullable();
            $table->decimal('actual_run_km', 10)->nullable();
            $table->integer('actual_run_month')->nullable();
            $table->decimal('alignment_interval_km', 10)->nullable();
            $table->enum('set_reminder_for_alignment', ['Yes', 'No'])->default('No');
            $table->decimal('rotation_interval_km', 10)->nullable();
            $table->enum('set_reminder_for_rotation', ['Yes', 'No'])->default('No');
            $table->decimal('last_alignment_km', 10)->nullable();
            $table->decimal('last_rotation_km', 10)->nullable();
            $table->text('discard_note')->nullable();
            $table->date('discard_date')->nullable();
            $table->bigInteger('created_by')->comment('FK → users.id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tyrelogs');
    }
};
