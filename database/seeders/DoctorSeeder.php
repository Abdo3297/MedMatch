<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctor_role = Role::updateOrCreate(['name' => RoleType::doctor->value], [
            'name' => RoleType::doctor->value,
            'guard_name' => 'web',
        ]);
        User::create([
            'name' => 'Doctor',
            'email' => 'doctor@gmail.com',
            'password' => bcrypt('doctor@gmail.com'),
            'ssn' => '0123456789',
            'email_verified_at' => now(),
        ])->assignRole($doctor_role);
    }
}
