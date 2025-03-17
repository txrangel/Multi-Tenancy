<?php
namespace App\Repositories;

use App\Models\User;


class UserProfileRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }
    public function save(User $user): bool
    {
        return $user->save();
    }
}