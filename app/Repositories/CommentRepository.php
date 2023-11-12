<?php
namespace App\Repositories;

use App\Contracts\Repositories\CommentRepositoryInterface;
use App\Models\Comment;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function getModel()
    {
        return Comment::class;
    }

    public function getCommentsByPost(string $postId)
    {
        return Comment::where('post_id',$postId)->get();
    }

    public function getCommentByUser(string $userId)
    {
        return Comment::where('user_id',$userId)->get();
    }

    public function getCommentByUserAndPost(string $userId, string $postId)
    {
        return Comment::where('post_id',$postId)->where('user_id',$userId);
    }
}