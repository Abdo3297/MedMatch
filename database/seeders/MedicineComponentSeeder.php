<?php

namespace Database\Seeders;

use App\Models\Component;
use App\Models\Medicine;
use Illuminate\Database\Seeder;

class MedicineComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicines = Medicine::all();
        $components = Component::all();
        foreach ($medicines as $medicine) {
            $selectedComponents = $components->random(20);
            foreach ($selectedComponents as $component) {
                $medicine->components()->attach($component->id);
            }
        }
    }
}
