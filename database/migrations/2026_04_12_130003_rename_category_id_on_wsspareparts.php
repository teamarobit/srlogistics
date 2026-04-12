<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Rename wsspareparts.category_id → wssparepartscategory_id
 * to use the conventional FK naming (table name prefix).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wsspareparts', function (Blueprint $table) {
            // Drop old FK, rename column, re-add FK under new name
            $table->dropForeign(['category_id']);
            $table->renameColumn('category_id', 'wssparepartscategory_id');
        });

        Schema::table('wsspareparts', function (Blueprint $table) {
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
            $table->renameColumn('wssparepartscategory_id', 'category_id');
        });

        Schema::table('wsspareparts', function (Blueprint $table) {
            $table->foreign('category_id')
                  ->references('id')
                  ->on('wssparepartscategories')
                  ->nullOnDelete();
        });
    }
};
