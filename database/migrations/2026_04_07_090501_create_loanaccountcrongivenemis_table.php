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
        Schema::create('loanaccountcrongivenemis', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('loanaccount_id')->comment('FK → loanaccounts.id');
            $table->bigInteger('vehicle_id')->comment('FK → vehicles.id');
            $table->date('emi_date')->nullable();
            $table->double('emi_amount')->default(0);
            $table->enum('status', ['Paid', 'Pending'])->nullable();
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
        Schema::dropIfExists('loanaccountcrongivenemis');
    }
};
