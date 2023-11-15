<?php

namespace App\Contracts\Repositories;
use App\Contracts\Repositories\BaseRepositoryInterface;

interface FriendshipRepositoryInterface extends BaseRepositoryInterface
{
    public function getFriendShip($userId, $friendId);
    public function getFriendsByUserId($userId);
    public function updateFriendshipStatus($userId, $friendId,$status);
    public function deleteFriendship($userId, $friendId);
    public function friendshipIsExist($userId, $friend_id);
}