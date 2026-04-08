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
        Schema::create('driverinfos', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->unsignedBigInteger('contact_id')->comment('FK → contacts.id');
            $table->enum('category', ['Local', 'Line'])->nullable();
            $table->string('driving_licence_no')->nullable();
            $table->date('licence_issue_date')->nullable();
            $table->date('licence_expiry_date')->nullable();
            $table->string('original_licence_location')->nullable();
            $table->string('driving_license_proof_file')->nullable();
            $table->string('aadhaar_no')->nullable();
            $table->string('aadhaar_card_proof_file')->nullable();
            $table->string('signed_driver_form_file')->nullable();
            $table->enum('status_type', ['On Leave', 'Voluntary Exit'])->nullable();
            $table->date('expected_return_date')->nullable();
            $table->enum('set_reminder', ['Yes', 'No'])->nullable();
            $table->longText('voluntary_exit_reason')->nullable();
            $table->enum('hisab_category', ['Fixed', 'Fuel'])->nullable();
            $table->date('opening_balance_date')->nullable();
            $table->enum('opening_balance_type', ['Credit', 'Debit'])->nullable()->comment('\'Credit - Receivable\',\'Debit - Payable\'');
            $table->double('opening_balance')->default(0);
            $table->string('guarantor_name')->nullable();
            $table->string('guarantor_phone_code', 10)->nullable();
            $table->string('guarantor_phone', 50)->nullable();
            $table->longText('exit_reason')->nullable();
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
        Schema::dropIfExists('driverinfos');
    }
};
