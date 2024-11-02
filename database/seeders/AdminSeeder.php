<?php

namespace Database\Seeders;

use App\Enums\PermissionAdminType;
use App\Enums\RoleType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Admin */
        //################################################
        foreach (PermissionAdminType::cases() as $permission) {
            Permission::updateOrCreate(['name' => $permission->value], [
                'name' => $permission->value,
                'guard_name' => 'web',
            ]);
        }
        //##
        $admin_role = Role::updateOrCreate(['name' => RoleType::admin->value], [
            'name' => RoleType::admin->value,
            'guard_name' => 'web',
        ]);
        $admin_role->givePermissionTo(array_map(fn ($permission) => $permission->value, PermissionAdminType::cases()));
        //##
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin@gmail.com'),
            'email_verified_at' => now(),
        ])->assignRole($admin_role);
    }
}
