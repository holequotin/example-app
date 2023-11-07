<?php
namespace App\Contracts\Repositories;

interface PostRepositoryInterface extends BaseRepositoryInterface{
    public function getPostsByUser(string $userId);
}