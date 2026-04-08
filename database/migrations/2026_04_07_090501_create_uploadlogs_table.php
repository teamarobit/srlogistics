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
        Schema::create('uploadlogs', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->unsignedBigInteger('scheduleupload_id')->comment('FK → scheduleuploads.id');
            $table->longText('note')->nullable();
            $table->enum('type', ['Success', 'Error'])->nullable();
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
        Schema::dropIfExists('uploadlogs');
    }
};
