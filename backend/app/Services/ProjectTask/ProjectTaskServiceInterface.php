<?php

namespace App\Services\ProjectTask;

use App\Services\AbstractServiceInterface;

interface ProjectTaskServiceInterface extends AbstractServiceInterface
{
    /**
     * The function handel update position task.
     *
     * @param int $projectId The id of project.
     * @param array $attributes The attribute.
     *
     * @return bool
     */
    public function updatePositionTask($projectId, $attributes);
}
