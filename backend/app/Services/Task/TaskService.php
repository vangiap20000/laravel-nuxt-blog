<?php

namespace App\Services\Task;

use App\Models\Task;
use App\Services\AbstractBaseService;
use App\Supports\TaskSupports;

class TaskService extends AbstractBaseService implements TaskServiceInterface
{
    use TaskSupports;

    /**
     * Get model.
     *
     * @return string
     */
    public function getModel()
    {
        return Task::class;
    }

    /**
     * The function handel update position task.
     *
     * @param array $attributes The attribute.
     *
     * @return bool
     */
    public function updatePositionTask($attributes)
    {
        $task = $this->find($attributes['id']);
        $task->update([
            'status' => $attributes['to_status'],
            'order' => $attributes['new_order'],
        ]);

        if ($attributes['from_status'] == $attributes['to_status']) {
            $this->updateSameStatus($attributes['from_status'], $attributes['id'], null, $attributes['new_order'], $attributes['old_order']);
        } else {
            $this->updateDifferentStatus($attributes['from_status'], $attributes['id'], null, null, $attributes['old_order']);
            $this->updateDifferentStatus($attributes['to_status'], $attributes['id'], null, $attributes['new_order']);
        }
    }
}
