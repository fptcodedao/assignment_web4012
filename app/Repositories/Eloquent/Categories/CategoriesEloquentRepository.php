<?php


namespace App\Repositories\Eloquent\Categories;


use App\Models\Categories;
use App\Repositories\Contracts\Categories\CategoriesRepositoryInterface;
use App\Repositories\Eloquent\EloquentRepository;
use Illuminate\Support\Facades\DB;

class CategoriesEloquentRepository extends EloquentRepository implements CategoriesRepositoryInterface
{
    public function getModel()
    {
        return Categories::class;
    }

    public function getNotDelete()
    {
        $this->_model = $this->_model->whereNull('deleted_at');
        return $this;
    }

    public function getTop()
    {
        return $this->_model->all()->take(5);
    }

}
