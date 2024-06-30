<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    protected $taskModel;

    public function __construct(
        Task $takModel
    )
    {
        $this->taskModel = $takModel;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json($this->taskModel->all(), 200);
        } catch (\Exception $exception) {
            return $this->resultRest(500, $exception);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->taskModel->create($request->all());
            return $this->resultRest();
        } catch (\Exception $exception) {
            return $this->resultRest(500, $exception);
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
            return $this->resultRest(500, $exception);
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
            return $this->resultRest(500, $exception);
        }
    }
}
