<?php


namespace App\DAL;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentRepositoryImpl implements EloquentRepositoryInterface
{
    /** @var Model|Builder */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param $id
     * @return Model
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param array $columns
     * @param array $relations
     *
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = [])
    {
        return $this->model->with($relations)->get($columns);
    }

    /**
     * @param integer $id
     * @param array   $relations
     * @return Model
     */
    public function findWithRelations($id, array $relations = [])
    {
        return $this->model->find($id)->load($relations);
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param $id
     * @return Model
     */
    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param $model
     * @return Model
     * @throws ModelNotFoundException
     */
    public function returnOrFail($model)
    {
        if ( ! $model) {
            throw (new ModelNotFoundException())->setModel(get_class($this->model));
        }

        return $model;
    }

    /**
     * @param array  $ids
     * @param string $column
     * @return Collection
     */
    public function findByIds(array $ids, $column = 'id')
    {
        return $this->model->whereIn($column, $ids)->get();
    }

    public function findByForeignId($id, $column = 'id')
    {
        return $this->model->where($column, $id)->get();
    }


    public function update(Model $model, array $attributes)
    {
        return $model->update($attributes);
    }

    /**
     * @param Model $model
     * @param array $attributes
     * @return Model
     */
    public function updateInMemory(Model $model, array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            $model->{$attribute} = $value;
        }
        $model->save();

        return $model;
    }

    /**
     * @param Model $model
     * @return boolean
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }

    /**
     * @param Model $model
     * @return boolean
     */
    public function restore(Model $model)
    {
        return $model->restore();
    }

    public function newQuery(): Builder
    {
        return $this->model->newQuery();
    }

    /**
     * @param array  $values
     * @param string $column
     * @return Collection
     */
    public function findByColumnValues(array $values, string $column)
    {
        return $this->model->whereIn($column, $values)->get();
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->model->count();
    }
}
