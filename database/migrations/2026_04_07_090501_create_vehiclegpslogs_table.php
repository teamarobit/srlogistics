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
        Schema::create('vehiclegpslogs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('vehiclegps_id')->comment('FK → vehiclegps.id');
            $table->bigInteger('vehicle_id')->comment('FK → vehicles.id');
            $table->bigInteger('parent_id')->nullable();
            $table->bigInteger('gpsprovider_id')->comment('FK → gpsproviders.id');
            $table->enum('gps_type', ['New', 'Renewal', 'Replacement'])->default('New');
            $table->double('gps_plan_cost')->default(0);
            $table->double('gps_device_cost')->default(0);
            $table->date('device_issue_date')->nullable();
            $table->integer('device_warranty')->nullable();
            $table->integer('device_remaining_warranty')->nullable();
            $table->integer('gps_plan_validity')->nullable();
            $table->date('gps_plan_start_date')->nullable();
            $table->date('gps_plan_renew_date')->nullable();
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
        Schema::dropIfExists('vehiclegpslogs');
    }
};
