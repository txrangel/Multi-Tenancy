<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
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
    public function findById(int $id): User
    {
        return $this->model->findOrFail(id: $id);
    }
    public function create(array $data): User
    {
        return $this->model->create(attributes: $data);
    }
    public function update(int $id, array $data): User
    {
        $user = $this->findById(id: $id);
        $user->update(attributes: $data);
        return $user;
    }
    public function delete(int $id): bool
    {
        $user = $this->findById(id: $id);
        return $user->delete();
    }
}