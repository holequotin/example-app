<?php
namespace App\Repositories;

use App\Contracts\Repositories\ReactionRepositoryInterface;
use App\Models\Reaction;

class ReactionRepository extends BaseRepository implements ReactionRepositoryInterface

{
    public function getModel()
    {
        return Reaction::class;
    }
    public function getReaction($userId, $postId)
    {
        return Reaction::where('user_id',$userId)
                    ->where('post_id',$postId)
                    ->first();
    }
    public function isExist($userId,$postId) 
    {
        return Reaction::where('user_id',$userId)
                    ->where('post_id',$postId)
                    ->exists();
    }
    public function getReactionByPost($postId)
    {
        return Reaction::where('post_id',$postId)->get();
    }
}