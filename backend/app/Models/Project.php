<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'about',
    ];

    /**
     * Get the userProjects for the blog projects.
     */
    public function userProjects(): HasMany
    {
        return $this->hasMany(UserProject::class);
    }

    /**
     * Get the projectTasks for the blog projects.
     */
    public function projectTasks(): HasMany
    {
        return $this->hasMany(ProjectTask::class);
    }

    /**
     * The users that belong to the role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_projects');
    }
}
