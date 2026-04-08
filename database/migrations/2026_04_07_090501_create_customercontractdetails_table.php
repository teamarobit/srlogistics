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
        Schema::create('customercontractdetails', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('customercontract_id')->comment('FK → customercontracts.id');
            $table->string('contract_file')->nullable();
            $table->date('contract_expiry_date')->nullable();
            $table->enum('set_reminder', ['Yes', 'No'])->default('No');
            $table->integer('reminder_days_before_expiry')->nullable();
            $table->unsignedBigInteger('created_by')->comment('FK → users.id');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK → users.id');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK → users.id');
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
        Schema::dropIfExists('customercontractdetails');
    }
};
