<?php
namespace App\Contracts\Repositories;

interface ReactionRepositoryInterface extends BaseRepositoryInterface
{
    public function getReaction($userId,$postId);
    public function getReactionByPost($postId);
}