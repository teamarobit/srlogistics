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
        Schema::table('contacts', function (Blueprint $table) {
            if (! Schema::hasColumn('contacts', 'about_type_id')) {
                $table->unsignedBigInteger('about_type_id')
                      ->nullable()
                      ->after('contact_name')
                      ->comment('FK → customerabouttypes.id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            if (Schema::hasColumn('contacts', 'about_type_id')) {
                $table->dropColumn('about_type_id');
            }
        });
    }
};
