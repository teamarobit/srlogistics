<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Seeds insurancecompanies if the table is empty.
 * Uses raw DB::table to avoid Eloquent model issues.
 * Safe to run multiple times — only inserts when count = 0.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Table might not exist yet if 200001 also pending
        if (!Schema::hasTable('insurancecompanies')) {
            return;
        }

        if (DB::table('insurancecompanies')->count() > 0) {
            return; // already seeded
        }

        $now = now()->toDateTimeString();

        DB::statement("INSERT INTO `insurancecompanies` (`name`, `code`, `status`, `created_at`) VALUES
            ('Bajaj Allianz General Insurance',       'BAJAJ',      'Active', '{$now}'),
            ('Bharti AXA General Insurance',          'BHARTIAX',   'Active', '{$now}'),
            ('Cholamandalam MS General Insurance',    'CHOLA',      'Active', '{$now}'),
            ('Future Generali India Insurance',       'FUTGEN',     'Active', '{$now}'),
            ('Go Digit General Insurance',            'DIGIT',      'Active', '{$now}'),
            ('HDFC ERGO General Insurance',           'HDFCERGO',   'Active', '{$now}'),
            ('ICICI Lombard General Insurance',       'ICICILOM',   'Active', '{$now}'),
            ('IFFCO Tokio General Insurance',         'IFFCO',      'Active', '{$now}'),
            ('Kotak Mahindra General Insurance',      'KOTAK',      'Active', '{$now}'),
            ('Liberty General Insurance',             'LIBERTY',    'Active', '{$now}'),
            ('Magma HDI General Insurance',           'MAGMA',      'Active', '{$now}'),
            ('National Insurance Company',            'NATIONAL',   'Active', '{$now}'),
            ('New India Assurance',                   'NEWINDIA',   'Active', '{$now}'),
            ('Oriental Insurance Company',            'ORIENTAL',   'Active', '{$now}'),
            ('Raheja QBE General Insurance',          'RAHEJA',     'Active', '{$now}'),
            ('Reliance General Insurance',            'RELIANCE',   'Active', '{$now}'),
            ('Royal Sundaram General Insurance',      'ROYAL',      'Active', '{$now}'),
            ('SBI General Insurance',                 'SBI',        'Active', '{$now}'),
            ('Shriram General Insurance',             'SHRIRAM',    'Active', '{$now}'),
            ('Star Health and Allied Insurance',      'STARHEALTH', 'Active', '{$now}'),
            ('Tata AIG General Insurance',            'TATAAIG',    'Active', '{$now}'),
            ('United India Insurance',                'UNITEDIND',  'Active', '{$now}'),
            ('Universal Sompo General Insurance',     'UNISOMPO',   'Active', '{$now}'),
            ('Zuno General Insurance (Edelweiss)',    'ZUNO',       'Active', '{$now}')
        ");
    }

    public function down(): void
    {
        DB::table('insurancecompanies')->truncate();
    }
};
