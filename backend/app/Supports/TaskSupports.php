<?php

namespace App\Supports;

trait TaskSupports
{
    public function updateDifferentStatus($statusId, $id, $projectId = null, $newIndex = null, $oldIndex = null)
    {
        $tasks = $this->model->where([
            'status' => $statusId,
            'user_id' => auth('web')->user()->id
        ]);

        if ($projectId) {
            $tasks->where('project_id', $projectId);
        }

        $tasks->whereNot('id', $id);

        if ($oldIndex) {
            $tasks->where('order', '>', $oldIndex)->decrement('order');
            $this->resetOrder($statusId, $projectId);

            return true;
        }

        $tasks->where('order', '>=', $newIndex)->increment('order');
        $this->resetOrder($statusId, $projectId);

        return true;
    }

    public function updateSameStatus($statusId, $id, $projectId = null, $newIndex = null, $oldIndex = null)
    {
        $tasks = $this->model->where([
            'status' => $statusId,
            'user_id' => auth('web')->user()->id
        ]);

        if ($projectId) {
            $tasks->where('project_id', $projectId);
        }

        $tasks->whereNot('id', $id);

        if ($newIndex < $oldIndex) {
            $tasks->where('order', '<', $oldIndex)->where('order', '>=', $newIndex)->increment('order');
        } else {
            $tasks->where('order', '<=', $newIndex)->where('order', '>', $oldIndex)->decrement('order');
        }

        $this->resetOrder($statusId, $projectId);
    }

    public function resetOrder($statusId, $projectId = null)
    {
        $tasks = $this->model
            ->where([
                'status' => $statusId,
                'user_id' => auth('web')->user()->id
            ]);

        if ($projectId) {
            $tasks->where('project_id', $projectId);
        }

        $tasks->orderBy('order')->get();

        foreach ($tasks as $key => $task) {
            $this->update($task->id, ['order' => $key + 1]);
        }
    }
}
