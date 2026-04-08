<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Attachmenttype;

class AttachmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
                    [
                        'name' => 'RC Document',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'Insurance',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'Pollution Certificate',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'Service Invoice',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'Warranty Document',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ];
                
        Attachmenttype::insert($data);
    }
}
