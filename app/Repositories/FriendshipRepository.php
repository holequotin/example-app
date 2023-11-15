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

    public function getFriendsByUserId($userId)
    {
        $friendship = Friendship::where('user_id',$userId)
                                ->orWhere('friend_id',$userId)
                                ->get();
        return $friendship;
    }

    public function updateFriendshipStatus($userId, $friendId,$status) {
        $friendship = $this->getFriendShip($userId,$friendId);
        if($friendship){
            $friendship->update(["status" => $status]);
        }
        return $friendship;
    }

    public function deleteFriendship($userId, $friendId)
    {
        $friendship = $this->getFriendShip($userId,$friendId);
        if($friendship) {
            return $friendship->delete();
        }
        return false;
    }

    public function friendshipIsExist($userId, $friend_id)
    {
        $friendship = $this->getFriendShip($userId, $friend_id);
        if($friendship) {
            return true;
        }
        return false;
    }
}