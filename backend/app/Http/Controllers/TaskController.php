<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Services\Task\TaskServiceInterface;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(
        TaskServiceInterface $taskService
    ) {
        $this->taskService = $taskService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Task $task)
    {
        try {
            $tasks = $task
                ->with('status')
                ->select(
                    ['id', 'title', 'type', 'content', 'created_at as date', 'order', 'status']
                )
                ->orderBy('order')
                ->get()
                ->groupBy('status');

            return response()->json($tasks, 200);
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            logger($message);
            return $this->resultRest(500, $message);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->taskService->create($request->all());
            return $this->resultRest();
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            logger($message);
            return $this->resultRest(500, $message);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        try {
            $result = $task->update($request->all());
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
    public function destroy(Task $task)
    {
        try {
            $result = $task->delete();
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

    public function handelMove(Request $request)
    {
        try {
            $this->taskService->updatePositionTask($request->all());

            return $this->resultRest();
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            logger($message);
            return $this->resultRest(500, $message);
        }
    }
}
