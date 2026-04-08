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
        Schema::create('vehiclebasicinfos', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('vehicle_id')->nullable()->comment('FK → vehicles.id');
            $table->text('vehicle_number');
            $table->string('owner_name');
            $table->longText('owner_address')->nullable();
            $table->string('owner_phone')->nullable();
            $table->date('registration_date')->nullable();
            $table->string('registration_status')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('model')->nullable();
            $table->string('vehicle_class')->nullable();
            $table->string('vehicle_category')->nullable();
            $table->string('body_type')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('emission_norms')->nullable();
            $table->string('engine_no')->nullable();
            $table->string('chassis_no')->nullable();
            $table->double('gross_vehicle_weight')->default(0);
            $table->double('unladen_weight')->default(0);
            $table->double('wheelbase')->default(0);
            $table->string('permit_type')->nullable();
            $table->text('permit_no')->nullable();
            $table->date('permit_expiry')->nullable();
            $table->date('national_permit_expiry')->nullable();
            $table->date('fitness_expiry')->nullable();
            $table->string('insurer')->nullable();
            $table->string('insurance_no')->nullable();
            $table->date('insurance_expiry')->nullable();
            $table->string('pucc_no')->nullable();
            $table->date('pucc_expiry')->nullable();
            $table->date('tax_expiry')->nullable();
            $table->string('commercial_fastag')->nullable();
            $table->string('fastagId')->nullable();
            $table->string('tid')->nullable();
            $table->date('fastag_issue_date')->nullable();
            $table->string('maker_model')->nullable();
            $table->string('financer')->nullable();
            $table->string('class')->nullable();
            $table->string('norms_type')->nullable();
            $table->timestamp('created_at')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiclebasicinfos');
    }
};
