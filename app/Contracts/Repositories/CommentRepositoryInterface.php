<?php
namespace App\Contracts\Repositories;

interface CommentRepositoryInterface extends BaseRepositoryInterface
{
    public function getCommentsByPost(string $postId);
    public function getCommentByUser(string $userId);
    public function getCommentByUserAndPost(string $userId, string $postId);
}