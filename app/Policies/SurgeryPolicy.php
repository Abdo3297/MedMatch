<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\Surgery;
use App\Models\User;

class SurgeryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(RoleType::doctor->value) || $user->hasRole(RoleType::radiologist->value);
    }

    public function view(User $user, Surgery $surgery): bool
    {
        return $user->hasRole(RoleType::doctor->value) || $user->hasRole(RoleType::radiologist->value);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(RoleType::doctor->value);
    }

    public function update(User $user, Surgery $surgery): bool
    {
        return $user->hasRole(RoleType::doctor->value);
    }

    public function delete(User $user, Surgery $surgery): bool
    {
        return $user->hasRole(RoleType::doctor->value);
    }
}
