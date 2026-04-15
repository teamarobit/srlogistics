<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Wire vehicleinsurancepolicies.insurancecompany_id to insurancecompanies.
 *
 * FK is intentionally skipped — MySQL 8 is strict about signed/unsigned
 * BIGINT compatibility across tables that follow different ID conventions.
 * Application-level validation (exists:insurancecompanies,id) is used instead.
 *
 * Handles:
 *  A) Column still named 'insurer_id'          → null it, drop old FK, rename
 *  B) Column already 'insurancecompany_id'     → drop stale FK if present
 *
 * Then ensures column is BIGINT UNSIGNED NULL (no FK constraint added).
 */
return new class extends Migration
{
    private function fkExists(string $fkName): bool
    {
        return DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('CONSTRAINT_SCHEMA', DB::getDatabaseName())
            ->where('TABLE_NAME', 'vehicleinsurancepolicies')
            ->where('CONSTRAINT_NAME', $fkName)
            ->where('CONSTRAINT_TYPE', 'FOREIGN KEY')
            ->exists();
    }

    public function up(): void
    {
        // ── Scenario A: column still has old name ───────────────────────────
        if (Schema::hasColumn('vehicleinsurancepolicies', 'insurer_id')) {
            DB::table('vehicleinsurancepolicies')->update(['insurer_id' => null]);

            if ($this->fkExists('vehicleinsurancepolicies_insurer_id_foreign')) {
                Schema::table('vehicleinsurancepolicies', function (Blueprint $table) {
                    $table->dropForeign(['insurer_id']);
                });
            }

            Schema::table('vehicleinsurancepolicies', function (Blueprint $table) {
                $table->renameColumn('insurer_id', 'insurancecompany_id');
            });
        }

        // ── Drop any stale FK on insurancecompany_id (from failed prior runs) ─
        if ($this->fkExists('vehicleinsurancepolicies_insurancecompany_id_foreign')) {
            Schema::table('vehicleinsurancepolicies', function (Blueprint $table) {
                $table->dropForeign(['insurancecompany_id']);
            });
        }

        // ── Ensure column is BIGINT UNSIGNED NULL (no FK — app validates) ───
        DB::statement('ALTER TABLE `vehicleinsurancepolicies` MODIFY COLUMN `insurancecompany_id` BIGINT UNSIGNED NULL');
    }

    public function down(): void
    {
        if ($this->fkExists('vehicleinsurancepolicies_insurancecompany_id_foreign')) {
            Schema::table('vehicleinsurancepolicies', function (Blueprint $table) {
                $table->dropForeign(['insurancecompany_id']);
            });
        }

        if (Schema::hasColumn('vehicleinsurancepolicies', 'insurancecompany_id')) {
            DB::statement('ALTER TABLE `vehicleinsurancepolicies` MODIFY COLUMN `insurancecompany_id` BIGINT UNSIGNED NULL');
            Schema::table('vehicleinsurancepolicies', function (Blueprint $table) {
                $table->renameColumn('insurancecompany_id', 'insurer_id');
            });
        }
    }
};
