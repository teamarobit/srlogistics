<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bring wsspareparts into multi-tenancy compliance (RULE 11).
     *
     * Existing rows are backfilled to organisation_id = 1.
     * Column is bigInteger (signed) to match the convention used by
     * organisations, expenses, fleetstatuses, organisationusers, etc.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('wsspareparts', 'organisation_id')) {
            Schema::table('wsspareparts', function (Blueprint $table) {
                $table->bigInteger('organisation_id')
                    ->default(1)
                    ->after('id')
                    ->comment('FK -> organisations.id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('wsspareparts', 'organisation_id')) {
            Schema::table('wsspareparts', function (Blueprint $table) {
                $table->dropColumn('organisation_id');
            });
        }
    }
};
