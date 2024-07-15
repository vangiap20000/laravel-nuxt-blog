<?php

namespace App\Services\Task;

use App\Services\AbstractServiceInterface;

interface TaskServiceInterface extends AbstractServiceInterface
{
    /**
     * The function handel update position task.
     *
     * @param array $attributes The attribute.
     *
     * @return bool
     */
    public function updatePositionTask($attributes);
}
