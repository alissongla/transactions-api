<?php

namespace App\Http\Repositories;

class BaseRepository
{
    public function __construct(protected $model)
    {
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findByCustomColumn($id, $column)
    {
        return $this->model->where($column, $id);
    }

    public function update($id, $data)
    {
        return $this->model->find($id)->update($data);
    }

    public function all()
    {
        return $this->model->all();
    }
}
