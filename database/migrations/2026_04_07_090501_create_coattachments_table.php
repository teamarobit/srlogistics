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
        Schema::create('coattachments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('coattachtype_id')->comment('FK → coattachtypes.id'); 
            $table->unsignedBigInteger('contact_id')->comment('FK → contacts.id');
            $table->string('name');
            $table->string('original_name');
            $table->double('file_size', 20, 5);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->softDeletes(); // deleted_at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coattachments');
    }
};
