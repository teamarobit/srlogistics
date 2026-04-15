<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

/**
 * Dedicated insurancecompanies lookup table.
 * Follows the same pattern as fasttagproviders / gpsproviders.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insurancecompanies', function (Blueprint $table) {
            $table->id();
            // $table->bigInteger('id', true);
            $table->string('name');
            $table->string('code', 50)->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->bigInteger('created_by')->nullable()->comment('FK → users.id');
            $table->bigInteger('updated_by')->nullable()->comment('FK → users.id');
            $table->bigInteger('deleted_by')->nullable()->comment('FK → users.id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->softDeletes();
        });

        /* ── Seed major Indian insurance companies ── */
        $now = now();
        DB::table('insurancecompanies')->insert([
            ['name' => 'Bajaj Allianz General Insurance',       'code' => 'BAJAJ',    'status' => 'Active', 'created_at' => $now],
            ['name' => 'Bharti AXA General Insurance',          'code' => 'BAXIA',    'status' => 'Active', 'created_at' => $now],
            ['name' => 'Cholamandalam MS General Insurance',    'code' => 'CHOLA',    'status' => 'Active', 'created_at' => $now],
            ['name' => 'Future Generali India Insurance',       'code' => 'FUTGEN',   'status' => 'Active', 'created_at' => $now],
            ['name' => 'Go Digit General Insurance',            'code' => 'DIGIT',    'status' => 'Active', 'created_at' => $now],
            ['name' => 'HDFC ERGO General Insurance',           'code' => 'HDFCERGO', 'status' => 'Active', 'created_at' => $now],
            ['name' => 'IFFCO Tokio General Insurance',         'code' => 'IFFCO',    'status' => 'Active', 'created_at' => $now],
            ['name' => 'ICICI Lombard General Insurance',       'code' => 'ICICILOM', 'status' => 'Active', 'created_at' => $now],
            ['name' => 'Kotak Mahindra General Insurance',      'code' => 'KOTAK',    'status' => 'Active', 'created_at' => $now],
            ['name' => 'Liberty General Insurance',             'code' => 'LIBERTY',  'status' => 'Active', 'created_at' => $now],
            ['name' => 'Magma HDI General Insurance',           'code' => 'MAGMA',    'status' => 'Active', 'created_at' => $now],
            ['name' => 'National Insurance Company',            'code' => 'NATIONAL', 'status' => 'Active', 'created_at' => $now],
            ['name' => 'New India Assurance',                   'code' => 'NEWINDIA', 'status' => 'Active', 'created_at' => $now],
            ['name' => 'Niva Bupa Health Insurance',            'code' => 'NIVABUPA', 'status' => 'Active', 'created_at' => $now],
            ['name' => 'Oriental Insurance Company',            'code' => 'ORIENTAL', 'status' => 'Active', 'created_at' => $now],
            ['name' => 'Raheja QBE General Insurance',          'code' => 'RAHEJA',   'status' => 'Active', 'created_at' => $now],
            ['name' => 'Reliance General Insurance',            'code' => 'RELIANCE', 'status' => 'Active', 'created_at' => $now],
            ['name' => 'Royal Sundaram General Insurance',      'code' => 'ROYAL',    'status' => 'Active', 'created_at' => $now],
            ['name' => 'SBI General Insurance',                 'code' => 'SBI',      'status' => 'Active', 'created_at' => $now],
            ['name' => 'Shriram General Insurance',             'code' => 'SHRIRAM',  'status' => 'Active', 'created_at' => $now],
            ['name' => 'Star Health and Allied Insurance',      'code' => 'STARHEALTH','status' => 'Active', 'created_at' => $now],
            ['name' => 'Tata AIG General Insurance',            'code' => 'TATAAIG',  'status' => 'Active', 'created_at' => $now],
            ['name' => 'United India Insurance',                'code' => 'UNITEDIND','status' => 'Active', 'created_at' => $now],
            ['name' => 'Universal Sompo General Insurance',     'code' => 'UNISOMPO', 'status' => 'Active', 'created_at' => $now],
            ['name' => 'Zuno General Insurance (Edelweiss)',    'code' => 'ZUNO',     'status' => 'Active', 'created_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('insurancecompanies');
    }
};
