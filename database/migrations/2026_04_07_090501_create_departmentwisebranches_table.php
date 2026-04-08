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
        Schema::create('departmentwisebranches', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('department_id')->comment('FK → departments.id');
            $table->bigInteger('branch_id')->comment('FK → branches.id');
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
        Schema::dropIfExists('departmentwisebranches');
    }
};
