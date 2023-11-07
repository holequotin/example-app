<?php
namespace App\Contracts\Repositories;

interface BaseRepositoryInterface {
    public function getAll();
    public function find(string $id);
    public function create(array $attribute);
    public function update(string $id,array $attribute);
    public function delete(string $id);
}