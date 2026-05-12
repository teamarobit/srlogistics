<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batterylogs', function (Blueprint $table) {
            $table->bigInteger('id', true);

            $table->bigInteger('battery_id')->comment('FK → batteries.id');
            $table->bigInteger('organisation_id')->default(1);

            // Action that triggered this log entry
            $table->enum('action', [
                'Added',
                'Updated',
                'Installed',
                'Removed',
                'Transferred',
                'Maintenance',
                'Condemned',
                'Disposed',
            ])->default('Added');

            // Snapshot fields at the time of the log entry
            $table->enum('battery_source_mode', ['Existing', 'New PO', 'Fitment'])->nullable();
            $table->string('battery_serial', 100)->nullable();
            $table->string('battery_brand', 100)->nullable();
            $table->string('battery_model', 100)->nullable();
            $table->decimal('battery_capacity', 8, 2)->nullable();
            $table->string('battery_voltage', 10)->nullable();
            $table->enum('battery_condition', ['New', 'Used', 'Replaced Under Warranty'])->nullable();

            $table->bigInteger('vendor_id')->nullable();
            $table->string('battery_invoice_ref', 100)->nullable();
            $table->decimal('battery_purchase_cost', 12, 2)->nullable();
            $table->date('battery_purchase_date')->nullable();
            $table->unsignedSmallInteger('battery_warranty_months')->default(0);
            $table->date('battery_warranty_expiry_date')->nullable();

            $table->date('battery_issue_date')->nullable();
            $table->unsignedSmallInteger('battery_fixed_life_months')->nullable();

            // Stock location at this log point
            $table->enum('stock_location_type', ['Warehouse', 'Workshop', 'Fitment', 'Unassigned'])->nullable();
            $table->bigInteger('warehouse_id')->nullable();
            $table->bigInteger('workshop_id')->nullable();

            // Vehicle allocation at this log point
            $table->bigInteger('vehicle_id')->nullable();
            $table->date('installation_date')->nullable();
            $table->unsignedInteger('odometer_km')->nullable();

            // Status at this log point
            $table->enum('battery_status', ['In Stock', 'Installed', 'In Repair', 'Condemned', 'Disposed'])->nullable();

            $table->text('log_notes')->nullable();

            $table->bigInteger('created_by')->comment('FK → users.id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batterylogs');
    }
};
