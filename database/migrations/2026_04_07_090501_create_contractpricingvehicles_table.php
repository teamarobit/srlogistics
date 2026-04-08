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
        Schema::create('contractpricingvehicles', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('contractpricing_id')->comment('FK → contractpricing.id');
            $table->bigInteger('vehicletype_id')->comment('FK → vehicletypes.id');
            $table->bigInteger('vehicletypesize_id')->comment('FK → vehicletypesizes.id');
            $table->double('price')->default(0);
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
        Schema::dropIfExists('contractpricingvehicles');
    }
};
