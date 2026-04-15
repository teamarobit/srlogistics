<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehiclebasicinfos', function (Blueprint $table) {
            $table->text('insurance_note')->nullable()->after('insurance_expiry')
                  ->comment('Internal note about this vehicle\'s insurance / renewal status');
        });
    }

    public function down(): void
    {
        Schema::table('vehiclebasicinfos', function (Blueprint $table) {
            $table->dropColumn('insurance_note');
        });
    }
};
