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
        Schema::create('emipaymentrecordnotes', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('loanaccountcrongivenemi_id')->comment('FK → loanaccountcrongivenemis.id');
            $table->enum('type', ['Note', 'Extra Charge'])->nullable();
            $table->longText('comment')->nullable();
            $table->double('extra_charge')->default(0);
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
        Schema::dropIfExists('emipaymentrecordnotes');
    }
};
