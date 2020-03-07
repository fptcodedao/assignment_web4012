<?php


namespace App\Repositories\Eloquent\Admin;


use App\Models\Admin;
use App\Repositories\Contracts\Admin\AdminRepositoryInterface;
use App\Repositories\Eloquent\EloquentRepository;

class AdminEloquentRepository extends EloquentRepository implements AdminRepositoryInterface
{

    public function getModel()
    {
        return Admin::class;
    }
}
