<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contactactivities', function (Blueprint $table) {
            $table->enum('is_voluntary_exit', ['Yes', 'No'])->default('No')->after('is_blacklisted');
        });
    }

    public function down(): void
    {
        Schema::table('contactactivities', function (Blueprint $table) {
            $table->dropColumn('is_voluntary_exit');
        });
    }
};
