<?php

namespace App\Http\Controllers;

use App\Http\Repositories\TaskRepository;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(TaskRepository $repository)
    {
        $this->taskRepository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TaskResource::collection($this->taskRepository->getTasks());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param StoreTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreTaskRequest $request)
    {
        $newTask = $this->taskRepository->createAndReturnTask($request);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Task added',
            'data' => [
                'item' => $newTask
            ]
        ], 200);
    }

    /**
     * @param Task $task
     * @return TaskResource
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param UpdateTaskRequest $request
     * @param Task $task
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
//        $this->taskRepository->
    }

    /**
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        $this->taskRepository->destroyTask($task);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Task deleted',
        ], 200);
    }
}
