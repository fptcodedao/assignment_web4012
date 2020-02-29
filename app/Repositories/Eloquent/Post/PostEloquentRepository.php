<?php


namespace App\Repositories\Eloquent\Post;


use App\Models\Post;
use App\Repositories\Contracts\Post\PostRepositoryInterface;
use App\Repositories\Eloquent\EloquentRepository;

class PostEloquentRepository extends EloquentRepository implements PostRepositoryInterface
{

    public function getModel()
    {
        return Post::class;
    }
}
