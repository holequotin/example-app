<?php

namespace App\Policies;

use App\Models\Friendship;
use App\Models\User;

class FriendshipPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Friendship $friendship) : bool
    {   
        return $user->id == $friendship->user_id || $user->id == $friendship->friend_id;
    }

    public function delete(User $user, Friendship $friendship) :bool
    {   
        if($friendship){
            return $user->id == $friendship->user_id || $user->id == $friendship->friend_id;
        }
        return false;
    }
}
