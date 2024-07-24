<?php

namespace App\Services\ProjectTask;

use App\Models\ProjectTask;
use App\Services\AbstractBaseService;
use App\Supports\TaskSupports;

class ProjectTaskService extends AbstractBaseService implements ProjectTaskServiceInterface
{
    use TaskSupports;

    /**
     * Get model.
     *
     * @return string
     */
    public function getModel()
    {
        return ProjectTask::class;
    }

    /**
     * The function handel update position task.
     *
     * @param int $projectId The id of project.
     * @param array $attributes The attribute.
     *
     * @return bool
     */
    public function updatePositionTask($projectId, $attributes) {
        $task = $this->find($attributes['id']);
        $task->update([
            'status' => $attributes['to_status'],
            'order' => $attributes['new_order'],
        ]);

        if ($attributes['from_status'] == $attributes['to_status']) {
            $this->updateSameStatus($attributes['from_status'], $attributes['id'], $projectId, $attributes['new_order'], $attributes['old_order']);
        } else {
            $this->updateDifferentStatus($attributes['from_status'], $attributes['id'], $projectId, null, $attributes['old_order']);
            $this->updateDifferentStatus($attributes['to_status'], $attributes['id'], $projectId, $attributes['new_order']);
        }
    }
}
