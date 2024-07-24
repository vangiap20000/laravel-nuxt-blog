<?php

namespace App\Services\ProjectTask;

use App\Models\ProjectTask;
use App\Services\AbstractBaseService;

class ProjectTaskService extends AbstractBaseService implements ProjectTaskServiceInterface
{
    /**
     * Get model.
     *
     * @return string
     */
    public function getModel()
    {
        return ProjectTask::class;
    }
}
