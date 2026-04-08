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
        Schema::create('loanaccounts', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('vehicle_id')->comment('FK → vehicles.id');
            $table->enum('type', ['Chassis', 'Body'])->nullable();
            $table->bigInteger('financeprovider_id')->comment('FK → financeproviders.id');
            $table->string('loan_account_no');
            $table->double('total_financer_amount')->default(0);
            $table->double('total_amt_with_interest')->default(0);
            $table->double('emi_amount')->default(0);
            $table->double('interest_amount')->default(0);
            $table->integer('total_months')->nullable();
            $table->integer('paid_upto_months')->nullable();
            $table->date('emi_start_date')->nullable();
            $table->date('emi_end_date')->nullable();
            $table->integer('emi_date_every_month')->nullable();
            $table->enum('set_reminder', ['Yes', 'No'])->default('No');
            $table->integer('emi_reminder_before_days')->nullable();
            $table->longText('notes')->nullable();
            $table->enum('status', ['Ongoing', 'Partially Paid', 'Overdue', 'Closed', 'Restructured'])->nullable();
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
        Schema::dropIfExists('loanaccounts');
    }
};
