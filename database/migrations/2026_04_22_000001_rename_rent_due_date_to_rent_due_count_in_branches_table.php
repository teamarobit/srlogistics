<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // For being a safe side we need to have the below line
        DB::table('branches')->update([
            'rent_due_date' => null,
        ]);
        
        Schema::table('branches', function (Blueprint $table) {
            $table->renameColumn('rent_due_date', 'rent_due_count');
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->unsignedBigInteger('rent_due_count')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->renameColumn('rent_due_count', 'rent_due_date');
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->date('rent_due_date')->nullable()->change();
        });
    }
};
