<?php

namespace App\Services;

interface AbstractServiceInterface
{
    /**
     * The function help find item by id.
     *
     * @param int $id      The id.
     * @param array   $columns The column.
     *
     * @return mixed
     */
    public function find(int $id, array $columns);

    /**
     * The function help get find or fail.
     *
     * @param int $id      The id.
     * @param array   $columns The column.
     *
     * @return mixed
     */
    public function findOrFail(int $id, array $columns);

    /**
     * The function help get record.
     *
     * @param array $conditions The condition.
     * @param array $columns    The column.
     *
     * @return mixed
     */
    public function get(array $conditions, array $columns);

    /**
     * The function add new record.
     *
     * @param array $attributes The attribute.
     *
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * The function help update record.
     *
     * @param int $id         The id.
     * @param array   $attributes The attribute.
     *
     * @return false|mixed
     */
    public function update(int $id, array $attributes);

    /**
     * The function help delete item.
     *
     * @param int $id The id.
     *
     * @return bool
     */
    public function delete(int $id);

    /**
     * The function help find by.
     *
     * @param mixed $attribute The attribute.
     * @param mixed $value     The id.
     *
     * @return mixed
     */
    public function findBy(mixed $attribute, mixed $value);
}
