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
        Schema::create('vehiclebatterylogs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('vehiclebattery_id')->comment('FK → vehiclebatteries.id');
            $table->bigInteger('vehicle_id')->comment('FK → vehicles.id');
            $table->string('battery_model_name');
            $table->string('battery_capacity')->nullable();
            $table->string('battery_brand')->nullable();
            $table->decimal('battery_price', 10)->default(0);
            $table->string('battery_serial_number')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('issue_date')->nullable();
            $table->integer('warranty_months')->nullable();
            $table->integer('fixed_life_months')->nullable();
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
        Schema::dropIfExists('vehiclebatterylogs');
    }
};
