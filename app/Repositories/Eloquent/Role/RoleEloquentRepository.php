<?php


namespace App\Repositories\Eloquent\Role;


use App\Models\Role;
use App\Repositories\Contracts\Role\RoleRepositoryInterface;
use App\Repositories\Eloquent\EloquentRepository;

class RoleEloquentRepository extends EloquentRepository implements RoleRepositoryInterface
{

    public function getModel()
    {
        return Role::class;
    }
}
