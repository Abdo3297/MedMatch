<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\Medicine;
use App\Models\User;

class MedicinePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(RoleType::doctor->value) || $user->hasRole(RoleType::radiologist->value);
    }

    public function view(User $user, Medicine $medicine): bool
    {
        return $user->hasRole(RoleType::doctor->value) || $user->hasRole(RoleType::radiologist->value);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(RoleType::doctor->value);
    }

    public function update(User $user, Medicine $medicine): bool
    {
        return $user->hasRole(RoleType::doctor->value);
    }

    public function delete(User $user, Medicine $medicine): bool
    {
        return $user->hasRole(RoleType::doctor->value);
    }
}
