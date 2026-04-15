<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insuranceclaims', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('organisation_id')->nullable()->comment('FK → organisations.id');
            $table->bigInteger('vehicle_id')->comment('FK → vehicles.id');
            $table->string('claim_number')->unique()->comment('Auto-generated e.g. CLM-2026-0001');
            $table->enum('settlement_mode', ['Reimbursement', 'Cashless'])->default('Reimbursement');
            $table->enum('workshop_type', ['Own', 'External'])->default('Own');
            $table->bigInteger('external_sc_id')->nullable()->comment('FK → contacts.id — only when workshop_type=External');
            $table->string('external_sc_claim_ref')->nullable()->comment('Ref raised by external SC (cashless only)');
            $table->string('insurer')->nullable();
            $table->string('policy_no')->nullable();
            $table->string('insurer_claim_ref')->nullable()->comment('Claim reference given by insurer');
            $table->string('damage_type')->nullable();
            $table->date('incident_date')->nullable();
            $table->string('incident_location')->nullable();
            $table->text('incident_description')->nullable();
            $table->string('fir_no')->nullable();
            $table->date('claim_filed_date')->nullable();
            $table->string('linked_job_card')->nullable();
            $table->decimal('repair_cost_estimate', 12, 2)->default(0)->comment('Estimated repair cost');
            $table->decimal('amount_claimed', 12, 2)->nullable()->comment('Amount filed with insurer');
            $table->decimal('amount_approved', 12, 2)->nullable()->comment('Amount approved by insurer');
            $table->decimal('amount_received', 12, 2)->nullable()->comment('Amount actually received');
            $table->decimal('excess_payable', 12, 2)->nullable()->comment('Compulsory excess (cashless)');
            $table->decimal('excess_paid', 12, 2)->nullable()->comment('Excess amount actually paid');
            $table->date('settlement_date')->nullable();
            $table->enum('status', [
                'Filed',
                'Surveyor Assigned',
                'Survey in Progress',
                'Insurer Approved',
                'Settlement Received',
                'Closed',
                'Rejected',
            ])->default('Filed');
            $table->enum('initiated_by', ['Fleet Manager', 'SC Manager', 'External SC'])->default('Fleet Manager');
            $table->text('notes')->nullable();
            $table->bigInteger('created_by')->comment('FK → users.id');
            $table->bigInteger('updated_by')->nullable()->comment('FK → users.id');
            $table->bigInteger('deleted_by')->nullable()->comment('FK → users.id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insuranceclaims');
    }
};
