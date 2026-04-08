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
        Schema::create('cobillings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contact_id')->comment('FK → contacts.id');
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->unsignedBigInteger('country_id')->nullable()->comment('FK → countries.id');
            $table->unsignedBigInteger('state_id')->nullable()->comment('FK → states.id');
            $table->unsignedBigInteger('city_id')->nullable()->comment('FK → cities.id');
            $table->string('zipcode', 50)->nullable();
            $table->string('comment')->nullable();
            $table->string('add_info')->nullable();
            $table->unsignedBigInteger('created_by')->comment('FK → users.id');
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
        Schema::dropIfExists('cobillings');
    }
};
