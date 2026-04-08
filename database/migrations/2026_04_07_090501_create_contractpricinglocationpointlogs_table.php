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
        Schema::create('contractpricinglocationpointlogs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('contractpricinglog_id')->comment('FK → contractpricinglogs.id');
            $table->enum('point_type', ['Source', 'Destination', 'Midpoint'])->nullable();
            $table->enum('location_type', ['Loading', 'Unloading', 'Both'])->nullable();
            $table->bigInteger('customerlocation_id')->comment('FK → customerlocations.id');
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
        Schema::dropIfExists('contractpricinglocationpointlogs');
    }
};
