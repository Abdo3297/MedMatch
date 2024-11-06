<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllergySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $total = 20;
        $chunk = 5;

        for ($i = 0; $i < $total; $i += $chunk) {
            $allergies = [];
            for ($j = 0; $j < $chunk; $j++) {
                $allergies[] = [
                    'name' => json_encode([
                        'ar' => fake('ar_SA')->sentence(),
                        'en' => fake()->sentence(),
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            DB::table('allergies')->insert($allergies);
        }
    }
}
