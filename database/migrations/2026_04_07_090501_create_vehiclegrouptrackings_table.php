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
        Schema::create('vehiclegrouptrackings', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('organisation_id')->comment('FK → organisations.id');
            $table->enum('ownership_type', ['Own', 'Rental'])->nullable();
            $table->bigInteger('vehicle_group_id')->comment('FK → vehiclegroups.id');
            $table->string('managed_by_employee')->nullable();
            $table->integer('no_of_vehicles')->nullable();
            $table->unsignedBigInteger('created_by')->comment('FK → users.id');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK → users.id');
            $table->bigInteger('deleted_by')->nullable()->comment('FK → users.id');
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
        Schema::dropIfExists('vehiclegrouptrackings');
    }
};
