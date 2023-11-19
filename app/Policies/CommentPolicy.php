<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Comment $comment)
    {
        return $user->id == $comment->user_id;
    }

    public function delete(User $user, Comment $comment)
    {
        if($comment) {
            return $user->id == $comment->user_id || $user->id == $comment->post->user_id;
        }
        return false;
    }
}
