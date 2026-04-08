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
        Schema::create('employeeallotedassetlogs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->unsignedBigInteger('employeeasset_id')->comment('FK → employeeassets.id');
            $table->unsignedBigInteger('contact_id')->comment('FK → contacts.id');
            $table->unsignedBigInteger('asset_id')->comment('FK → assets.id');
            $table->date('revoke_date')->nullable();
            $table->longText('comment')->nullable();
            $table->enum('status', ['Assigned', 'Unassigned'])->default('Assigned');
            $table->unsignedBigInteger('created_by')->comment('FK → users.id');
            $table->bigInteger('updated_by')->nullable()->comment('FK → users.id');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK → users.id');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employeeallotedassetlogs');
    }
};
