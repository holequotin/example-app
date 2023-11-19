<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user) : bool
    {
        return auth()->check();
    }

    public function update(User $user, Post $post) : bool
    {   
        return auth()->user()->id == $post->user_id;
    }

    public function delete(User $user, Post $post) : bool
    {
        if($post)
        {
            return $post->user_id == $user->id;
        }
        return false;
    }
}
