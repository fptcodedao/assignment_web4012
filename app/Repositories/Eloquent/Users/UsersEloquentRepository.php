<?php


namespace App\Repositories\Eloquent\Users;


use App\Models\User;
use App\Repositories\Contracts\Users\UsersRepositoryInterface;
use App\Repositories\Eloquent\EloquentRepository;

class UsersEloquentRepository extends EloquentRepository implements UsersRepositoryInterface
{

    public function getModel()
    {
        return User::class;
    }
}
