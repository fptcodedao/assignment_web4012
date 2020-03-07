<?php


namespace App\Repositories\Eloquent\Comment;


use App\Models\Comment;
use App\Repositories\Contracts\Comment\CommentRepositoryInterface;
use App\Repositories\Eloquent\EloquentRepository;

class CommentEloquentRepository extends EloquentRepository implements CommentRepositoryInterface
{

    public function getModel()
    {
        return Comment::class;
    }
}
