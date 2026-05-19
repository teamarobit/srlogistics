<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->bigInteger('id', true);

            $table->string('trip_id', 50)->unique()->comment('Auto-generated trip reference e.g. TRIP0001');
            $table->bigInteger('organisation_id')->default(1);

            $table->date('trip_date')->nullable();

            $table->enum('trip_type', ['Own', 'Rental', 'External'])->nullable();
            $table->enum('trip_category', ['Line', 'Local'])->nullable();

            // Load vendor (contact id)
            $table->bigInteger('load_vendor_id')->nullable()->comment('FK → contacts.id');

            $table->enum('rag_status', ['Red', 'Yellow', 'Green'])->nullable();

            // Customer (contact id)
            $table->bigInteger('customer_id')->nullable()->comment('FK → contacts.id');

            // Vehicle
            $table->bigInteger('vehicletype_id')->nullable()->comment('FK → vehicletypes.id');
            $table->bigInteger('vehicletypesize_id')->nullable()->comment('FK → vehicletypesizes.id');
            $table->bigInteger('vehicle_id')->nullable()->comment('FK → vehicles.id');

            $table->string('internal_trip_id', 100)->nullable();

            // Route
            $table->bigInteger('route_id')->nullable()->comment('FK → routes.id');
            $table->string('source', 255)->nullable();
            $table->string('destination', 255)->nullable();
            $table->string('midpoint', 255)->nullable();
            $table->string('distance', 50)->nullable();

            // LR fields
            $table->date('lr_date')->nullable();
            $table->string('lr_number', 100)->nullable();

            $table->enum('priority', ['Normal', 'Urgent'])->default('Normal');
            $table->enum('tarpaulin', ['Yes', 'No'])->nullable();

            $table->enum('trip_status', ['Initiated', 'Ongoing', 'Completed', 'Cancelled'])->default('Initiated');
            $table->enum('payment_status', ['Pending', 'Partial', 'Completed'])->default('Pending');

            $table->text('pod_remarks')->nullable();
            $table->text('comment')->nullable();

            $table->bigInteger('created_by')->nullable()->comment('FK → users.id');
            $table->bigInteger('updated_by')->nullable()->comment('FK → users.id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
