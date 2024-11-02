<?php

namespace Database\Seeders;

use App\Enums\PermissionDoctorType;
use App\Enums\RoleType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Doctor */
        //################################################
        foreach (PermissionDoctorType::cases() as $permission) {
            Permission::updateOrCreate(['name' => $permission->value], [
                'name' => $permission->value,
                'guard_name' => 'web',
            ]);
        }
        //##
        $doctor_role = Role::updateOrCreate(['name' => RoleType::doctor->value], [
            'name' => RoleType::doctor->value,
            'guard_name' => 'web',
        ]);
        $doctor_role->givePermissionTo(array_map(fn ($permission) => $permission->value, PermissionDoctorType::cases()));
        //##
        User::create([
            'name' => 'Doctor',
            'email' => 'doctor@gmail.com',
            'password' => bcrypt('doctor@gmail.com'),
            'email_verified_at' => now(),
        ])->assignRole($doctor_role);
    }
}
