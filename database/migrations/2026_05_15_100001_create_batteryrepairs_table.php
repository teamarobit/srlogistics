<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batteryrepairs', function (Blueprint $table) {
            // Legacy PK — signed bigint (matches project convention)
            $table->bigInteger('id', true);

            // Core FK — signed bigint to match legacy tables
            $table->bigInteger('battery_id')->comment('FK → batteries.id');
            $table->index('battery_id');

            $table->bigInteger('vehicle_id')->nullable()->comment('FK → vehicles.id');
            $table->index('vehicle_id');

            // Repair classification (SD-11: Title Case ENUMs)
            $table->enum('repair_category', ['Major', 'Minor'])->default('Minor');

            // Repair type — battery-specific
            $table->enum('repair_type', [
                'Terminal Cleaning',
                'Electrolyte Top-up',
                'Cell Replacement',
                'Reconditioning',
                'Other',
            ])->default('Other');

            // Financial
            $table->decimal('cost', 10, 2)->nullable();

            // Vendor (FK → contacts.id, signed bigint)
            $table->bigInteger('vendor_id')->nullable();
            $table->index('vendor_id');

            // Service details
            $table->date('repair_date')->nullable();
            $table->bigInteger('repair_km')->nullable();

            // Notes
            $table->text('notes')->nullable();

            // Org + audit (SD-12)
            $table->bigInteger('organisation_id')->default(1);
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batteryrepairs');
    }
};
