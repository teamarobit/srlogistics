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
        Schema::create('vehicledigitallocks', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('vehicle_id')->comment('FK → vehicles.id');
            $table->bigInteger('digitallockprovider_id')->comment('FK → digitallockproviders.id');
            $table->string('lockId')->nullable();
            $table->date('lock_issue_date')->nullable();
            $table->integer('lock_warranty_months')->nullable();
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
        Schema::dropIfExists('vehicledigitallocks');
    }
};
