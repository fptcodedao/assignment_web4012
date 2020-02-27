<?php


namespace App\Repositories\Eloquent;


use App\Models\Post;

class PostEloquentRepository extends EloquentRepository
{

    public function getModel()
    {
        return Post::class;
    }
}
