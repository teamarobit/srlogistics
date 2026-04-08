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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->unsignedBigInteger('organisation_id')->nullable()->comment('FK → organisations.id');
            $table->enum('ownership_type', ['Own', 'Rental'])->nullable();
            $table->text('vehicle_no');
            $table->unsignedBigInteger('vehiclegroup_id')->comment('FK → vehiclegroups.id	');
            $table->unsignedBigInteger('vehicletype_id')->comment('FK → vehicletypes.id');
            $table->unsignedBigInteger('vehicletypesize_id')->comment('FK → vehicletypesizes.id');
            $table->unsignedInteger('mounted_tyre_count');
            $table->enum('category', ['Local', 'Line'])->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->bigInteger('created_by')->comment('FK → users.id');
            $table->bigInteger('updated_by')->nullable()->comment('FK → users.id');
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
        Schema::dropIfExists('vehicles');
    }
};
