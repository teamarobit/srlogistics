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
        Schema::table('contractpricingvehicles', function (Blueprint $table) {
            $table->double('weight', 20, 5)->default(0.00000)->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contractpricingvehicles', function (Blueprint $table) {
            $table->dropColumn('weight');
        });
    }
};
