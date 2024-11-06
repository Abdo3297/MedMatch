<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\Allergy;
use App\Models\User;

class AllergyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(RoleType::doctor->value) || $user->hasRole(RoleType::radiologist->value);
    }

    public function view(User $user, Allergy $allergy): bool
    {
        return $user->hasRole(RoleType::doctor->value) || $user->hasRole(RoleType::radiologist->value);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(RoleType::doctor->value);
    }

    public function update(User $user, Allergy $allergy): bool
    {
        return $user->hasRole(RoleType::doctor->value);
    }

    public function delete(User $user, Allergy $allergy): bool
    {
        return $user->hasRole(RoleType::doctor->value);
    }
}
