<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Workshop Spare Parts Category master table.
 * Table name: wssparepartscategories (WS module naming convention)
 * BA approved — April 2026.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wssparepartscategories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('organisation_id')->nullable();
            $table->string('name', 100);
            $table->string('code', 30)->nullable()->unique();
            $table->text('description')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wssparepartscategories');
    }
};
