<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Dedicated insurancecompanies lookup table.
 * Follows the same pattern as fasttagproviders / gpsproviders.
 *
 * SD-2: Schema only — no seed data here.
 * Seed data lives in: database/seeders/InsurancecompanySeeder.php
 * Run seeds with: php artisan db:seed --class=InsurancecompanySeeder
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('insurancecompanies')) {
            return; // table already exists (created in a prior session)
        }

        Schema::create('insurancecompanies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 50)->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->bigInteger('created_by')->nullable()->comment('FK → users.id');
            $table->bigInteger('updated_by')->nullable()->comment('FK → users.id');
            $table->bigInteger('deleted_by')->nullable()->comment('FK → users.id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurancecompanies');
    }
};
