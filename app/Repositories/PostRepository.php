<?php
namespace App\Repositories;
use App\Contracts\Repositories\PostRepositoryInterface;
use App\Models\Post;

class PostRepository extends BaseRepository implements PostRepositoryInterface  {
    public function getModel()
    {
        return Post::class;
    }

    public function getPostsByUser(string $userId)
    {
        return Post::where('user_id',$userId)->get();
    }

    public function getAll()
    {
        return $this->_model::orderBy('created_at','desc')->get();
    }
}