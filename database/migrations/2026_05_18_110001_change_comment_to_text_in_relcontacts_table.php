<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('relcontacts', function (Blueprint $table) {
            $table->text('comment')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('relcontacts', function (Blueprint $table) {
            $table->string('comment')->nullable()->change();
        });
    }
};
