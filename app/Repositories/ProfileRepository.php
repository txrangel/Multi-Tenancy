<?php
namespace App\Repositories;

use App\Models\Profile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProfileRepository
{
    protected $model;

    public function __construct(Profile $model)
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
    public function findById(int $id): Profile
    {
        return $this->model->findOrFail(id: $id);
    }
    public function create(array $data): Profile
    {
        return $this->model->create(attributes: $data);
    }
    public function update(int $id, array $data): Profile
    {
        $profile = $this->findById(id: $id);
        $profile->update(attributes: $data);
        return $profile;
    }
    public function delete(int $id): bool
    {
        $profile = $this->findById(id: $id);
        return $profile->delete();
    }
}