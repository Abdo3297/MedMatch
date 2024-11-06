<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\Disease;
use App\Models\User;

class DiseasePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(RoleType::doctor->value) || $user->hasRole(RoleType::radiologist->value);
    }

    public function view(User $user, Disease $disease): bool
    {
        return $user->hasRole(RoleType::doctor->value) || $user->hasRole(RoleType::radiologist->value);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(RoleType::doctor->value);
    }

    public function update(User $user, Disease $disease): bool
    {
        return $user->hasRole(RoleType::doctor->value);
    }

    public function delete(User $user, Disease $disease): bool
    {
        return $user->hasRole(RoleType::doctor->value);
    }
}
