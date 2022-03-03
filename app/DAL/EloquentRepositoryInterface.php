<?php


namespace App\DAL;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface EloquentRepositoryInterface
{
    /**
     * @param $id
     * @return Model
     */
    public function find($id);

    /**
     * @param array $columns
     * @param array $relations
     *
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []);

    /**
     * @param integer $id
     * @param array   $relations
     * @return Model
     */
    public function findWithRelations($id, array $relations = []);

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes);

    /**
     * @param $id
     * @return Model
     */
    public function findOrFail($id);

    /**
     * @param $model
     * @return Model
     * @throws ModelNotFoundException
     */
    public function returnOrFail($model);

    /**
     * @param array  $ids
     * @param string $column
     * @return Collection
     */
    public function findByIds(array $ids, $column = 'id');

    /**
     * @param        $id
     * @param string $column
     * @return Model
     */
    public function findByForeignId($id, $column = 'id');

    /**
     * @param Model $model
     * @param array $attributes
     * @return bool
     */
    public function update(Model $model, array $attributes);

    /**
     * @param Model $model
     * @param array $attributes
     * @return Model
     */
    public function updateInMemory(Model $model, array $attributes);

    /**
     * @param Model $model
     * @return boolean
     */
    public function delete(Model $model);

    /**
     * @param Model $model
     * @return boolean
     */
    public function restore(Model $model);

    /**
     * @return Builder
     */
    public function newQuery(): Builder;

    /**
     * @param array $values
     * @param string $column
     * @return Collection
     */
    public function findByColumnValues(array $values, string $column);

    /**
     * @return int
     */
    public function count(): int;
}
