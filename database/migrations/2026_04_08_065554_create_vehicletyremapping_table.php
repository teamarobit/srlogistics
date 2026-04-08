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
        Schema::create('vehicletyremapping', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vehicle_id');
            $table->bigInteger('tyre_id');
            $table->bigInteger('tyreposition_id');
            $table->date('fitment_date')->nullable();
            $table->unsignedBigInteger('km_at_fitment')->nullable();
            $table->date('removal_date')->nullable();
            $table->unsignedBigInteger('km_at_removal')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Spare'])->default('Active');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicletyremapping');
    }
};
