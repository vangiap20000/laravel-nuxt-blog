<?php

namespace App\Services\Task;

use App\Models\Task;
use App\Services\AbstractBaseService;
use Illuminate\Support\Facades\DB;

class TaskService extends AbstractBaseService implements TaskServiceInterface
{
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
            $this->updateSameStatus($attributes['from_status'], $attributes['id'], $attributes['new_order'], $attributes['old_order']);
        } else {
            $this->updateDifferentStatus($attributes['from_status'], $attributes['id'], null, $attributes['old_order']);
            $this->updateDifferentStatus($attributes['to_status'], $attributes['id'], $attributes['new_order']);
        }
    }

    protected function updateDifferentStatus($statusId, $id, $newIndex = null, $oldIndex = null)
    {
        $tasks = $this->model->where('status', $statusId)->whereNot('id', $id);

        if ($oldIndex) {
            $tasks->where('order', '>', $oldIndex)->decrement('order');
            $this->resetOrder($statusId);

            return true;
        }

        $tasks->where('order', '>=', $newIndex)->increment('order');
        $this->resetOrder($statusId);

        return true;
    }

    protected function updateSameStatus($statusId, $id, $newIndex = null, $oldIndex = null) 
    {
        $tasks = $this->model->where('status', $statusId)->whereNot('id', $id);

        if ($newIndex < $oldIndex) {
            $tasks->where('order', '<', $oldIndex)->where('order', '>=', $newIndex)->increment('order');
        } else {
            $tasks->where('order', '<=', $newIndex)->where('order', '>', $oldIndex)->decrement('order');
        }

        $this->resetOrder($statusId);
    }

    public function resetOrder($statusId)
    {       
        $tasks = $this->model->where('status', $statusId)->orderBy('order')->get();
        foreach ($tasks as $key => $task) {
            $this->update($task->id, ['order' => $key + 1]);
        }
    }
}
