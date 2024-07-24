<?php

namespace App\Services\Project;

use App\Services\AbstractServiceInterface;

interface ProjectServiceInterface extends AbstractServiceInterface
{
    /**
     * The function handel create new project.
     *
     * @param array $attributes The attribute.
     *
     * @return mixed
     */
    public function createProject($attributes);
}
