<?php

namespace App\Contracts\Repositories;
use App\Contracts\Repositories\BaseRepositoryInterface;

interface FriendshipRepositoryInterface extends BaseRepositoryInterface
{
    public function getFriendShip($userId, $friendId);
    public function getFriendsByUserId($userId);
}