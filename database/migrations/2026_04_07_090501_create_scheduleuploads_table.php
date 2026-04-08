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
        Schema::create('scheduleuploads', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('module_name');
            $table->string('batch_no')->nullable();
            $table->string('file_name');
            $table->string('file_original_name')->nullable();
            $table->string('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('created_by')->comment('FK → users.id');
            $table->enum('status', ['Pending', 'Ongoing', 'Completed'])->nullable();
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
        Schema::dropIfExists('scheduleuploads');
    }
};
