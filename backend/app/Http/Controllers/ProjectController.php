<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Services\Project\ProjectServiceInterface;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(
        ProjectServiceInterface $projectService
    ) {
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        try {
            $projects = $project
                ->with([
                    'users' => function ($queryUser) {
                        return $queryUser
                            ->selectRaw('IF(users.id=' . auth('web')->user()->id . ', 0, users.id) AS special_user')
                            ->orderBy('special_user');
                    }
                ])
                ->whereHas('users', function ($queryUser) {
                    return $queryUser->where('users.id', auth('web')->user()->id);
                })
                ->select('*')
                ->selectRaw('TIMESTAMPDIFF(DAY, created_at, NOW()) AS days_since_created')
                ->get();

            return response()->json($projects, 200);
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            logger($message);
            return $this->resultRest(500, $message);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->projectService->createProject($request->all());
            DB::commit();
            return $this->resultRest();
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            logger($message);
            DB::rollBack();
            return $this->resultRest(500, $message);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        try {
            return response()->json($project, 200);
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            logger($message);
            return $this->resultRest(500, $message);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project)
    {
        try {
            DB::beginTransaction();
            $project->update($request->all());
            $project->users()->sync($request->input('users'));
            $project->userProjects()->create([
                'user_id' => auth('web')->user()->id,
                'role' => config('const.projects.role.value.owner')
            ]);
            DB::commit();

            return $this->resultRest();
        } catch (\Exception $exception) {
            DB::rollBack();
            $message = $exception->getMessage();
            logger($message);
            return $this->resultRest(500, $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            $project->projectTasks()->delete();
            $project->userProjects()->delete();
            $project->delete();

            return $this->resultRest();
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            logger($message);
            return $this->resultRest(500, $message);
        }
    }
}
