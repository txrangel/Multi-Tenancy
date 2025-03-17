<?php
namespace App\Services;

use App\Models\Profile;
use App\Repositories\ProfileRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProfileService
{
    protected $repository;

    public function __construct(ProfileRepository $repository)
    {
        $this->repository = $repository;
    }
    public function getAllProfiles()
    {
        return $this->repository->all();
    }
    public function getPaginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->paginate(perPage: $perPage);
    }
    public function findById(int $id): Profile
    {
        return $this->repository->findById(id: $id);
    }
    public function create(array $data): Profile
    {
        try {
            return $this->repository->create(data: $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function update(int $id, array $data): Profile
    {
        try {
            return $this->repository->update(id: $id, data: $data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function delete(int $id): bool
    {
        try {
            return $this->repository->delete(id: $id);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function syncPermissions(Profile $profile, array $permissionIds): array
    {
        return $profile->permissions()->sync(ids: $permissionIds);
    }
}