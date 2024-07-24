<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\ProjectTask;
use App\Services\ProjectTask\ProjectTaskServiceInterface;

class ProjectTaskController extends Controller
{
    protected $projectTaskService;

    public function __construct(
        ProjectTaskServiceInterface $projectTaskService
    ) {
        $this->projectTaskService = $projectTaskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ProjectTask $projectTask, $projectId)
    {
        try {
            $projectTasks = $projectTask
                ->with('status')
                ->select(
                    ['id', 'title', 'type', 'content', 'created_at as date', 'order', 'status']
                )
                ->where('project_id', $projectId)
                ->orderBy('order')
                ->get()
                ->groupBy('status');

            return response()->json($projectTasks, 200);
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
    public function store(TaskRequest $request, $projectId)
    {
        try {
            
            $data = $request->all();
            $data['user_id'] = auth('web')->user()->id;
            $data['project_id'] = $projectId;
            $this->projectTaskService->create($data);

            return $this->resultRest();
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            logger($message);
            return $this->resultRest(500, $message);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(TaskRequest $request, ProjectTask $projectTask)
    {
        try {
            $result = $projectTask->update($request->all());
            if (!$result) {
                return $this->resultRest(500, 'Fail');
            }

            return $this->resultRest();
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            logger($message);
            return $this->resultRest(500, $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectTask $projectTask)
    {
        try {
            $result = $projectTask->delete();
            if (!$result) {
                return $this->resultRest(500, 'Fail');
            }

            return $this->resultRest();
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            logger($message);
            return $this->resultRest(500, $message);
        }
    }
}
