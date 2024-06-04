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

    public function find($modelId)
    {
        return $this->model->find($modelId);
    }

    public function findByCustomColumn($modelId, $column)
    {
        return $this->model->where($column, $modelId)->first();
    }

    public function update($modelId, $data)
    {
        return $this->model->find($modelId)->update($data);
    }

    public function all()
    {
        return $this->model->all();
    }

    public function delete($modelId)
    {
        return $this->model->find($modelId)->delete();
    }

    public function restore($modelId)
    {
        $model = $this->model->withTrashed()->find($modelId);
        if ($model) {
            $model->restore();

            return $model;
        }

        return null;
    }

    public function findTrashed($modelId)
    {
        return $this->model->withTrashed()->find($modelId);
    }
}
