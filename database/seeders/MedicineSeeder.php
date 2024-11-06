<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $total = 20;
        $chunk = 5;

        for ($i = 0; $i < $total; $i += $chunk) {
            $medicines = [];
            for ($j = 0; $j < $chunk; $j++) {
                $medicines[] = [
                    'name' => json_encode([
                        'ar' => fake('ar_SA')->sentence(),
                        'en' => fake()->sentence(),
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::table('medicines')->insert($medicines);
        }
    }
}
