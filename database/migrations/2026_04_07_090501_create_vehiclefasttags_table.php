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
        Schema::create('vehiclefasttags', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('vehicle_id')->comment('FK → vehicles.id');
            $table->bigInteger('fasttagprovider_id')->comment('FK → fasttagproviders.id');
            $table->string('fasttag_bank_name')->nullable();
            $table->string('fasttagId')->nullable();
            $table->date('fasttag_issue_date')->nullable();
            $table->bigInteger('created_by')->comment('FK → users.id');
            $table->bigInteger('updated_by')->nullable()->comment('FK → users.id');
            $table->bigInteger('deleted_by')->nullable()->comment('FK → users.id');
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
        Schema::dropIfExists('vehiclefasttags');
    }
};
