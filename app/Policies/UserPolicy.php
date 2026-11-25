<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can change the role of the given user.
     */
    public function updateRole(User $actor, User $target): bool
    {
        return $actor->isAdmin() && ! $actor->is($target);
    }
}
