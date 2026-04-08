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
        Schema::create('contactactivities', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('contact_id')->comment('FK → contacts.id');
            $table->longText('notes');
            
            $table->enum('is_blacklisted', ['Yes', 'No'])->default('No');

            $table->unsignedBigInteger('created_by')->nullable()->comment('FK → users.id'); 
            $table->unsignedBigInteger('updated_by')->nullable()->comment('FK → users.id'); 
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('FK → users.id'); 

            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactactivities');
    }
};
