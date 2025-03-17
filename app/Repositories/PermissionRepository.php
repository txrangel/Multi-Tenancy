<?php
namespace App\Repositories;

use App\Models\Permission;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PermissionRepository
{
    protected $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }
    public function all()
    {
        return $this->model->orderby('name')->get();
    }
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->orderby('name')->paginate(perPage: $perPage);
    }
    public function findById(int $id): Permission
    {
        return $this->model->findOrFail(id: $id);
    }
    public function create(array $data): Permission
    {
        return $this->model->create(attributes: $data);
    }
    public function update(int $id, array $data): Permission
    {
        $permission = $this->findById(id: $id);
        $permission->update(attributes: $data);
        return $permission;
    }
    public function delete(int $id): bool
    {
        $permission = $this->findById(id: $id);
        return $permission->delete();
    }
}