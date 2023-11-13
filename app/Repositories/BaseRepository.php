<?php

namespace App\Repositories;

use App\Contracts\Repositories\BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $_model;
    public function __construct()
    {
        $this->setModel();
    }

    public function setModel()
    {
        $this->_model = $this->getModel();
    }

    abstract function getModel();

    public function getAll()
    {
        return $this->_model::all();
    }

    public function find($id) 
    {
        return $this->_model::find($id);
    }

    public function create(array $attribute)
    {
        return $this->_model::create($attribute);
    }

    public function update(string $id, array $attribute)
    {
        $object = $this->_model::find($id);
        if($object) {
            $object->update($attribute);
        }
        return $object;
    }

    public function delete(string $id)
    {
        $object = $this->find($id);
        if($object) {
            return $object->delete();
        }
        return false;
    }
}
