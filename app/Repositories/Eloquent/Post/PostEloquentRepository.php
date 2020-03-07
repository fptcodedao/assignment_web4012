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

    public function getHighTop()
    {
        return $this->_model->orderBy('view', 'desc')->get()->take(5);
    }
}
