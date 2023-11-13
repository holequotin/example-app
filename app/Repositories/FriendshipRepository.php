<?php
namespace App\Repositories;

use App\Contracts\Repositories\FriendshipRepositoryInterface;
use App\Models\Friendship;
use App\Repositories\BaseRepository;

class FriendshipRepository extends BaseRepository implements FriendshipRepositoryInterface
{
    public function getModel()
    {
        return Friendship::class;
    }

    public function getFriendShip($userId, $friendId)
    {
        $friendShip = Friendship::where(function ($query) use ($userId,$friendId)
                                {
                                    $query->where('user_id',$userId)
                                        ->where('friend_id',$friendId);
                                })
                                ->orWhere(function ($query) use($userId,$friendId)
                                {
                                    $query->where('user_id',$friendId)
                                        ->where('friend_id',$userId);
                                })
                                ->first();
        return $friendShip;
    }
}