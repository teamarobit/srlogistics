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
        Schema::create('employeesalaries', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('contact_id')->comment('FK → contacts.id');
            $table->double('basic_pay')->default(0);
            $table->double('salary_per_work')->default(0);
            $table->date('effective_from');
            $table->unsignedBigInteger('created_by')->comment('FK → users.id');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK → users.id');
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
        Schema::dropIfExists('employeesalaries');
    }
};
