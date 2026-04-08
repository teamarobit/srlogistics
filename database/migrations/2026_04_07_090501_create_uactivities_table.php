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
        Schema::create('uactivities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('actmodel_id');
            $table->unsignedBigInteger('actoperation_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('rowid');
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('uactivities');
    }
};
