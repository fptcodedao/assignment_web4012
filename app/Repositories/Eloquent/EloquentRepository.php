<?php


namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Support\Arr;
abstract class EloquentRepository implements RepositoryInterface
{
    protected $_model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel(){
        $this->_model = app()->make(
            $this->getModel()
        );
    }

    public function getTableColumns($except = []) {
        $columns = $this->_model
            ->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($this->_model->getTable());
        $columns = array_flip($columns);
        $columns = Arr::except($columns, $except);
        return array_flip($columns);
    }

    public function getAll($columns = array('*'))
    {
        return $this->_model->all($columns);
    }

    public function get($columns = ['*'])
    {
        return $this->_model->get($columns);
    }

    public function count()
    {
        return $this->_model->count();
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->_model->find($id);

        return $result;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {

        return $this->_model->create($attributes);
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    /**
     * Delete
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();
            return true;
        }
        return false;
    }

    public function with($relations)
    {
        $this->_model = $this->_model->with($relations);
        return $this;
    }

    public function findOrFail($id, $columns = ['*']){
        return $this->_model->findOrFail($id, $columns);
    }

    public function where($column, $operator = null, $value = null, $boolean = 'and'){
        $this->_model = $this->_model->where($column, $operator, $value, $boolean);
        return $this;
    }


    public function whereNull($columns, $boolean = 'and', $not = false){
        $this->_model = $this->_model->whereNull($columns, $boolean = 'and', $not = false);
        return $this;
    }

    public function whereNotNull($columns, $boolean = 'and'){
        $this->_model = $this->_model->whereNotNull($columns, $boolean = 'and');
        return $this;
    }

    /**
     * @param $column
     * @param null $operator
     * @param null $value
     * @return $this
     */
    public function orWhere($column, $operator = null, $value = null)
    {
        $this->_model = $this->_model->orWhere($column, $operator, $value);
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function offset($value)
    {
        $this->_model = $this->_model->offset($value);
        return $this;
    }

    /**
     * @param $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->_model = $this->_model->orderBy($column, $direction);
        return $this;
    }

    /**
     * Set the "limit" value of the query.
     *
     * @param  int  $value
     * @return $this
     */
    public function limit($value){
        $this->_model = $this->_model->limit($value);
        return $this;
    }

    /**
     * @param string|array $column
     * @param null|string|int $value
     * @return $this
     */
    public function search($column, $value = null)
    {
        $query = $this->_model->query();
        if (is_array($column)){
            foreach($column as $key){
                $query = $this->orWhere($key, 'like', '%'.$value.'%');
            }
        }else{
            $query = $this->where($column, 'like', '%'.$value.'%');
        }
        return $query;
    }
}
