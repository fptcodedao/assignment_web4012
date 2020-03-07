<?php


namespace App\Repositories\Contracts;


interface RepositoryInterface
{
    public function getAll($columns = array('*'));

    public function get($columns = ['*']);

    public function create(array $attributes);

    public function update($id, array $attributes);

    public function delete($id);

    public function with($relations);

    public function search($column, $value);

    public function findOrFail($id, $columns = ['*']);

    public function count();

    public function orWhere($column, $operator = null, $value = null);

    public function orderBy($column, $direction = 'asc');

    public function offset($value);

    public function limit($value);

    public function paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null);

    public function first($columns = ['*']);
}
