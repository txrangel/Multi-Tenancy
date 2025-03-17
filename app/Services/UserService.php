<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendPasswordMail;

class UserService
{
    protected $repository;

    public function __construct(UserRepository $repository)
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
    public function findById(int $id): User
    {
        return $this->repository->findById(id: $id);
    }
    public function create(array $data, PasswordService $passwordService): User
    {
        try {
            $data['password']   = $passwordService->generate();
            $user               = $this->repository->create(data: $data);
            Mail::to(users: $user->email)->send(mailable: new SendPasswordMail(password: $data['password']));

            return $user;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function update(int $id, array $data): User
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
    public function syncProfiles(User $user, array $profileIds): array
    {
        return $user->profiles()->sync(ids: $profileIds);
    }
}