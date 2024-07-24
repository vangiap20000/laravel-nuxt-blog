<?php

namespace App\Services\Project;

use App\Models\Project;
use App\Services\AbstractBaseService;

class ProjectService extends AbstractBaseService implements ProjectServiceInterface
{
    /**
     * Get model.
     *
     * @return string
     */
    public function getModel()
    {
        return Project::class;
    }

    /**
     * The function handel create new project.
     *
     * @param array $attributes The attribute.
     *
     * @return bool
     */
    public function createProject($attributes)
    {
        $project = $this->create($attributes);
        $project->users()->sync($attributes['users']);
        $project->userProjects()->create([
            'user_id' => auth('web')->user()->id,
            'role' => config('const.projects.role.value.owner')
        ]);

        return true;
    }
}
