<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Vehicle Insurance Policies table.
 * Stores per-vehicle insurance policy records (separate from claims).
 *
 * NOTE: vehiclebasicinfos.id uses signed bigInteger (not unsignedBigInteger),
 * so vehicle_id must also be signed bigInteger to satisfy MySQL FK type-match.
 * contacts.id uses bigIncrements (unsigned), so insurer_id is unsignedBigInteger.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('vehicleinsurancepolicies'); // safe re-run if table already exists

        Schema::create('vehicleinsurancepolicies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vehicle_id')          // signed — matches vehiclebasicinfos.id (bigInteger)
                  ->comment('FK → vehiclebasicinfos.id');
            $table->unsignedBigInteger('insurancecompany_id')->nullable()
                  ->comment('FK → insurancecompanies.id');
            $table->string('policy_number', 100)->nullable();
            $table->enum('policy_type', ['Comprehensive', 'Third Party', 'Zero Dep', 'Commercial'])->default('Comprehensive');
            $table->decimal('insured_value', 14, 2)->nullable()->comment('IDV / Sum Insured');
            $table->decimal('premium_amount', 14, 2)->nullable();
            $table->date('policy_start_date')->nullable();
            $table->date('policy_end_date')->nullable();
            $table->enum('status', ['Active', 'Expired', 'Cancelled'])->default('Active');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // vehiclebasicinfos uses bigInteger PK — must use matching signed type
            $table->foreign('vehicle_id')->references('id')->on('vehiclebasicinfos')->cascadeOnDelete();
            $table->foreign('insurancecompany_id')->references('id')->on('insurancecompanies')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicleinsurancepolicies');
    }
};
