<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_role = Role::updateOrCreate(['name' => RoleType::admin->value], [
            'name' => RoleType::admin->value,
            'guard_name' => 'web',
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin@gmail.com'),
            'ssn' => '1234567890',
            'email_verified_at' => now(),
        ])->assignRole($admin_role);
    }
}
