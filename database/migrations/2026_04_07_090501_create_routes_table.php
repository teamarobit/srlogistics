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
        Schema::create('routes', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('organisation_id')->nullable()->comment('FK → organisations.id');
            $table->longText('name')->nullable();
            $table->bigInteger('source_state_id')->comment('FK → states.id');
            $table->bigInteger('source_city_id')->comment('FK → cities.id');
            $table->bigInteger('destination_state_id')->comment('FK → states.id');
            $table->bigInteger('destination_city_id')->comment('FK → cities.id');
            $table->double('fixed_km')->default(0);
            $table->integer('transit_time_days')->default(0);
            $table->decimal('transit_time_hrs', 5)->default(0);
            $table->decimal('fixed_diesel_bs3_bs4', 6)->default(0);
            $table->decimal('fixed_diesel_bs6', 6)->default(0);
            $table->double('fixed_driver_advance')->default(0);
            $table->longText('remarks')->nullable();
            $table->enum('route_type', ['Line', 'Local'])->default('Line');
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
        Schema::dropIfExists('routes');
    }
};
