<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Replace the free-text `category` column on wsspareparts
 * with a FK to wssparepartscategories.
 *
 * Column is named wssparepartscategory_id (table-prefix convention).
 * The old `category` varchar column is kept temporarily (nullable)
 * to allow data migration. It can be dropped in a future migration.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wsspareparts', function (Blueprint $table) {
            $table->unsignedBigInteger('wssparepartscategory_id')->nullable()->after('category');
            $table->foreign('wssparepartscategory_id')
                  ->references('id')
                  ->on('wssparepartscategories')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('wsspareparts', function (Blueprint $table) {
            $table->dropForeign(['wssparepartscategory_id']);
            $table->dropColumn('wssparepartscategory_id');
        });
    }
};
