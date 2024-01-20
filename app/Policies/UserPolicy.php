<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function editProfile(User $user, User $profile){
        return $user->id === $profile->id ; 
    }
}
