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
        /*create roles*/
        foreach (RoleType::cases() as $role) {
            Role::updateOrCreate(['name' => $role->value], [
                'name' => $role->value,
                'guard_name' => 'web',
            ]);
        }
        /*create users*/
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin@gmail.com'),
            'ssn' => '7418529635',
            'email_verified_at' => now(),
        ])->assignRole(RoleType::admin->value);
        User::create([
            'name' => 'Doctor',
            'email' => 'doctor@gmail.com',
            'password' => bcrypt('doctor@gmail.com'),
            'ssn' => '9638527415',
            'email_verified_at' => now(),
        ])->assignRole(RoleType::doctor->value);
        User::create([
            'name' => 'Radiologist',
            'email' => 'radiologist@gmail.com',
            'password' => bcrypt('radiologist@gmail.com'),
            'ssn' => '1593578235',
            'email_verified_at' => now(),
        ])->assignRole(RoleType::radiologist->value);
    }
}
