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
        Schema::create('relcontacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contact_id')->comment('FK → contacts.id');
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->string('relationship')->nullable();
            $table->string('ph_prefix', 10)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('whatsapp_prefix', 10)->nullable();
            $table->string('whatsapp', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->enum('blood_group', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            $table->string('comment')->nullable();
            $table->unsignedBigInteger('created_by')->nullable()->comment('FK → users.id');
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK → users.id');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK → users.id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relcontacts');
    }
};
