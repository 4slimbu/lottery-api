<?php

namespace App\Acme\Policies;

use App\Acme\Models\User;
use App\Acme\Models\JobEcomm;

class UserPolicy
{
    public function getUsers(User $user)
    {
        return false;
    }

    public function createUser(User $user)
    {
        return false;
    }

    public function showUser(User $user)
    {
        return false;
    }

    public function updateUser(User $user)
    {
        return false;
    }

    public function destroyUser(User $user)
    {
        return false;
    }
}