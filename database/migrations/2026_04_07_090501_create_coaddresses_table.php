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
        Schema::create('coaddresses', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->unsignedBigInteger('contact_id')->comment('FK → contacts.id');
            $table->enum('type', ['Present', 'Permanent'])->default('Permanent');
            $table->text('address')->nullable();
            $table->unsignedBigInteger('state_id')->comment('FK → states.id');
            $table->unsignedBigInteger('city_id')->nullable()->comment('FK → cities.id');
            $table->string('zipcode', 20)->nullable();
            $table->text('additional_info')->nullable();
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
        Schema::dropIfExists('coaddresses');
    }
};
