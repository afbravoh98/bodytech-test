<?php

namespace App\Base;

/**
 * Class BaseRepository
 * @package Bric\Base
 */
abstract class BaseRepository
{
    /**
     * @var array
     */
    public $filters = [];

    /**
     * @return mixed
     */
    abstract public function getModel();

    /**
     * @param $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        return $this->getModel()->findOrFail($id);
    }
    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->getModel()->create($data);
    }

    /**
     * @param $entity
     * @param array $data
     * @return mixed
     */
    public function update($entity, array $data)
    {
        $entity->fill($data);
        $entity->save();
        return $entity;
    }

    /**
     * @param $entity
     * @return mixed
     */
    public function delete($entity)
    {
        if (is_numeric($entity)) {
            $entity = $this->findOrFail($entity);
        }
        $entity->delete();
        return $entity;
    }

    public function getQuery()
    {
        return $this->getModel()->query();
    }

    public function all()
    {
        return $this->getModel()->all();
    }

    public function count()
    {
        return $this->getModel()->count();
    }

}
