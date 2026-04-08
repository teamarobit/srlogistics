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
        Schema::create('tollstations', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('organisation_id')->nullable()->comment('FK → organisations.id');
            $table->string('tollstationno')->unique('tollstationno');
            $table->string('station_name')->nullable();
            $table->string('toll_company')->nullable();
            $table->unsignedBigInteger('state_id')->comment('FK → states.id');
            $table->unsignedBigInteger('city_id')->comment('FK → cities.id');
            $table->longText('embed_map_location')->nullable();
            $table->longText('address')->nullable();
            $table->bigInteger('currency_id')->comment('FK → currencies.id');
            $table->double('large_vehicle_charge')->default(0);
            $table->double('medium_vehicle_charge')->default(0);
            $table->double('small_vehicle_charge')->default(0);
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
        Schema::dropIfExists('tollstations');
    }
};
