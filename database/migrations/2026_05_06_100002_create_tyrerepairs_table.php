<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tyrerepairs', function (Blueprint $table) {
            // Legacy PK — signed bigint (matches project convention)
            $table->bigInteger('id', true);

            // Core FKs — signed bigint to match legacy tables
            $table->bigInteger('tyre_id')->comment('FK → tyres.id');
            $table->index('tyre_id');

            $table->bigInteger('vehicle_id')->nullable()->comment('FK → vehicles.id');
            $table->index('vehicle_id');

            $table->bigInteger('tyreposition_id')->nullable()->comment('FK → tyrepositions.id');

            // Repair classification (SD-11: Title Case ENUMs)
            $table->enum('repair_category', ['Major', 'Minor'])->default('Minor');

            // Repair type
            $table->enum('repair_type', [
                'Re-thread',
                'Tyre Puncture',
                'Tube Replace',
                'Valve Change',
                'Other',
            ])->default('Tyre Puncture');

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
        Schema::dropIfExists('tyrerepairs');
    }
};
