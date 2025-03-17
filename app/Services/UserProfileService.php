<?php
namespace App\Services;

use App\Http\Requests\UserProfileUpdate;
use App\Repositories\UserProfileRepository;
class UserProfileService
{
    protected $repository;

    public function __construct(UserProfileRepository $repository)
    {
        $this->repository = $repository;
    }
    public function update(UserProfileUpdate $request): bool
    {
        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        return $this->repository->save(user: $request->user());
    }
}