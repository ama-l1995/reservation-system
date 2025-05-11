<?php

namespace App\Repositories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;

class ServiceRepository
{
    protected $model;

    public function __construct(Service $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $service = $this->find($id);
        $service->update($data);
        return $service;
    }

    public function delete($id)
    {
        $service = $this->find($id);
        $service->delete();
    }
}
