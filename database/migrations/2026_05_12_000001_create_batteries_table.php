<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batteries', function (Blueprint $table) {
            // SD-RULE: signed BIGINT PK (legacy pattern for this project)
            $table->bigInteger('id', true); // auto-increment, signed

            // ── Organisation ──────────────────────────────────────────────
            $table->bigInteger('organisation_id')->default(1);

            // ── Source mode ───────────────────────────────────────────────
            $table->enum('battery_source_mode', ['Existing', 'New PO', 'Fitment'])->default('New PO');
            $table->string('source_origin_note', 500)->nullable();        // Existing mode
            $table->string('fitment_source_origin_note', 500)->nullable(); // Fitment mode
            $table->string('purchase_order_reference', 100)->nullable();   // New PO GRN/PO ref

            // ── Battery identity ──────────────────────────────────────────
            $table->string('battery_serial', 100);
            $table->string('battery_brand', 100);
            $table->string('battery_model', 100)->nullable();
            $table->decimal('battery_capacity', 8, 2);      // Ah
            $table->string('battery_voltage', 10);           // e.g. 12V, 24V
            $table->enum('battery_condition', ['New', 'Used', 'Replaced Under Warranty'])->default('New');

            // ── Purchase / vendor ─────────────────────────────────────────
            $table->bigInteger('vendor_id')->nullable();     // contacts.id (cotype=7)
            $table->string('battery_invoice_ref', 100)->nullable();
            $table->string('invoice_file_path', 500)->nullable();
            $table->decimal('battery_purchase_cost', 12, 2)->nullable();
            $table->date('battery_purchase_date')->nullable();
            $table->unsignedSmallInteger('battery_warranty_months')->default(0);
            $table->date('battery_warranty_expiry_date')->nullable();

            // ── Lifecycle & usage ─────────────────────────────────────────
            $table->date('battery_issue_date')->nullable();
            $table->unsignedSmallInteger('battery_fixed_life_months')->nullable();
            $table->date('battery_end_of_life_date')->nullable();
            $table->unsignedSmallInteger('battery_actual_usage_months')->nullable();

            // ── Maintenance tracking ──────────────────────────────────────
            $table->date('last_voltage_check_date')->nullable();
            $table->date('last_charging_check_date')->nullable();
            $table->unsignedTinyInteger('battery_health_pct')->nullable();  // 0-100
            $table->date('next_inspection_due_date')->nullable();
            $table->boolean('maintenance_reminder_enabled')->default(false);

            // ── Stock location ────────────────────────────────────────────
            $table->bigInteger('warehouse_id')->nullable();  // if stored at warehouse
            $table->bigInteger('workshop_id')->nullable();   // if stored at workshop / fitment
            $table->enum('stock_location_type', ['Warehouse', 'Workshop', 'Fitment', 'Unassigned'])
                  ->default('Unassigned');

            // ── Allocation (filled on vehicle assignment) ─────────────────
            $table->enum('current_status', ['In Stock', 'Installed', 'In Repair', 'Condemned', 'Disposed'])
                  ->default('In Stock');
            $table->bigInteger('allocated_vehicle_id')->nullable();
            $table->date('installation_date')->nullable();
            $table->unsignedInteger('current_odometer_km')->nullable();

            // ── Notes ─────────────────────────────────────────────────────
            $table->text('battery_notes')->nullable();

            // ── Audit ─────────────────────────────────────────────────────
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // ── Indexes ───────────────────────────────────────────────────
            $table->index('organisation_id');
            $table->index('battery_serial');
            $table->index('current_status');
            $table->index('warehouse_id');
            $table->index('workshop_id');
            $table->index('allocated_vehicle_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batteries');
    }
};
