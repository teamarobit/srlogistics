<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('banks')->insert([
            ['name' => 'State Bank of India (SBI)', 'created_at' => now()],
            ['name' => 'Bank of Baroda', 'created_at' => now()],
            ['name' => 'Punjab National Bank (PNB)', 'created_at' => now()],
            ['name' => 'Bank of India', 'created_at' => now()],
            ['name' => 'Canara Bank', 'created_at' => now()],
            ['name' => 'Union Bank of India', 'created_at' => now()],
            ['name' => 'Bank of Maharashtra', 'created_at' => now()],
            ['name' => 'Central Bank of India', 'created_at' => now()],
            ['name' => 'Indian Bank', 'created_at' => now()],
            ['name' => 'Indian Overseas Bank', 'created_at' => now()],
            ['name' => 'UCO Bank', 'created_at' => now()],
            ['name' => 'Punjab & Sind Bank', 'created_at' => now()],
            ['name' => 'HDFC Bank', 'created_at' => now()],
            ['name' => 'ICICI Bank', 'created_at' => now()],
            ['name' => 'Kotak Mahindra Bank', 'created_at' => now()],
            ['name' => 'Axis Bank', 'created_at' => now()],
            ['name' => 'IndusInd Bank', 'created_at' => now()],
            ['name' => 'Federal Bank', 'created_at' => now()],
            ['name' => 'Yes Bank', 'created_at' => now()],
            ['name' => 'Bandhan Bank', 'created_at' => now()],
            ['name' => 'IDFC FIRST Bank', 'created_at' => now()],
            ['name' => 'South Indian Bank', 'created_at' => now()],
            ['name' => 'Karnataka Bank', 'created_at' => now()],
            ['name' => 'City Union Bank', 'created_at' => now()],
            ['name' => 'Dhanlaxmi Bank', 'created_at' => now()],
        ]);
    }
}