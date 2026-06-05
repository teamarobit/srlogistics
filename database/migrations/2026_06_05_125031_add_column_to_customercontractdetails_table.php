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
        Schema::table('customercontractdetails', function (Blueprint $table) {
            $table->bigInteger('organisation_id')->after('id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customercontractdetails', function (Blueprint $table) {
            $table->dropColumn('organisation_id');
        });
    }
};
