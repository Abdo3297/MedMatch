<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // admin
        $admin_role = Role::updateOrCreate(['name' => RoleType::admin->value], [
            'name' => RoleType::admin->value,
            'guard_name' => 'web',
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin@gmail.com'),
            'ssn' => '7418529635',
            'email_verified_at' => now(),
        ])->assignRole($admin_role);
        // doctor
        $doctor_role = Role::updateOrCreate(['name' => RoleType::doctor->value], [
            'name' => RoleType::doctor->value,
            'guard_name' => 'web',
        ]);
        User::create([
            'name' => 'Doctor',
            'email' => 'doctor@gmail.com',
            'password' => bcrypt('doctor@gmail.com'),
            'ssn' => '9638527415',
            'email_verified_at' => now(),
        ])->assignRole($doctor_role);
        // radiologist
        $radiologist_role = Role::updateOrCreate(['name' => RoleType::radiologist->value], [
            'name' => RoleType::radiologist->value,
            'guard_name' => 'web',
        ]);
        User::create([
            'name' => 'Radiologist',
            'email' => 'radiologist@gmail.com',
            'password' => bcrypt('radiologist@gmail.com'),
            'ssn' => '1593578235',
            'email_verified_at' => now(),
        ])->assignRole($radiologist_role);
    }
}
