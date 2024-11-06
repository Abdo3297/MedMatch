<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(RoleType::doctor->value) || $user->hasRole(RoleType::radiologist->value);
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasRole(RoleType::doctor->value) || $user->hasRole(RoleType::radiologist->value);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(RoleType::doctor->value);
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasRole(RoleType::doctor->value) || $user->hasRole(RoleType::radiologist->value);
    }

    public function delete(User $user, User $model): bool
    {
        return $user->hasRole(RoleType::doctor->value);
    }
}
