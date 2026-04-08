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
        Schema::create('routemidpoints', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('route_id')->comment('FK → routes.id	');
            $table->bigInteger('state_id')->comment('FK → states.id');
            $table->bigInteger('city_id')->comment('FK → cities.id');
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
        Schema::dropIfExists('routemidpoints');
    }
};
