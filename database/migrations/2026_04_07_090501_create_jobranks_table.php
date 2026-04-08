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
        Schema::create('jobranks', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('organisation_id')->nullable()->comment('FK → organisations.id');
            $table->unsignedBigInteger('department_id')->comment('FK → departments.id');
            $table->unsignedBigInteger('designation_id')->comment('FK → designations.id');
            $table->string('name');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
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
        Schema::dropIfExists('jobranks');
    }
};
