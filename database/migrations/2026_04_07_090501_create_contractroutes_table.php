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
        Schema::create('contractroutes', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('customercontract_id')->comment('FK → customercontracts.id');
            $table->bigInteger('route_id')->comment('FK → routes.id');
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
        Schema::dropIfExists('contractroutes');
    }
};
