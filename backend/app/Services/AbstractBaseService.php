<?php

namespace App\Services;

/**
 * Class AbstractBaseService.
 */
abstract class AbstractBaseService implements AbstractServiceInterface
{
    /**
     * The model.
     *
     * @var object
     */
    protected object $model;

    /**
     * AbstractBaseService constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * The abstract method getModel.
     *
     * @return mixed
     */
    abstract public function getModel();

    /**
     * The setter model.
     *
     * @return void
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    /**
     * The function help get record.
     *
     * @param array $conditions The condition.
     * @param array $columns    The column.
     *
     * @return mixed
     */
    public function get(array $conditions = [], array $columns = ['*'])
    {
        return $this->model->where($conditions)->select($columns)->get();
    }

    /**
     * The function help find item by id.
     *
     * @param int $id      The id.
     * @param array   $columns The column.
     *
     * @return mixed
     */
    public function find(int $id, array $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    /**
     * The function help get find or fail.
     *
     * @param int $id      The id.
     * @param array   $columns The column.
     *
     * @return mixed
     */
    public function findOrFail(int $id, array $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * The function add new record.
     *
     * @param array $attributes The attribute.
     *
     * @return mixed
     */
    public function create(array $attributes = [])
    {
        $this->model->fill($attributes);

        return $this->model->create($attributes);
    }

    /**
     * The function help update record.
     *
     * @param int $id         The id.
     * @param array   $attributes The attribute.
     *
     * @return false|mixed
     */
    public function update(int $id, array $attributes = [])
    {
        $result = $this->find($id);
        if ($result) {
            $this->model->fill($attributes);
            $result->update($attributes);

            return $result;
        }

        return false;
    }

    /**
     * The function help delete item.
     *
     * @param int $id The id.
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        $result = $this->find($id);
        if ($result) {
            return $result->delete();
        }

        return false;
    }

    /**
     * The function help find by.
     *
     * @param mixed $attribute The attribute.
     * @param mixed $value     The id.
     *
     * @return mixed
     */
    public function findBy(mixed $attribute, mixed $value)
    {
        return $this->model->where($attribute, $value)->first();
    }
}
