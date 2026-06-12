<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Issue 23 — "Others" assets showed a blank Purchase Date because the table had
     * no dedicated purchase_date column (dates were rc_date/warranty_* /issue_date/assigned_on).
     * Add a nullable purchase_date column captured for every asset type.
     */
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->date('purchase_date')->nullable()->after('rc_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn('purchase_date');
        });
    }
};
