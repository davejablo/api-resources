<?php

namespace App\Http\Controllers;

use App\Http\Repositories\TaskRepository;
use App\Http\RepositoryInterfaces\TaskRepositoryInterface;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserResource;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskRepositoryInterface;

    public function __construct(TaskRepositoryInterface $taskInterface)
    {
        $this->taskRepositoryInterface = $taskInterface;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return TaskResource::collection($this->taskRepositoryInterface->getTasks());
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
        $newTask = $this->taskRepositoryInterface->createAndReturnTask($request);

        return response()->json([
            'code' => 201,
            'status' => 'success',
            'message' => 'Task added',
            'data' => [
                'item' => $newTask
            ]
        ], 201);
    }

    /**
     * @param Task $task
     * @return TaskResource
     */
    public function show(Task $task)
    {
        return new TaskResource($this->taskRepositoryInterface->getTask($task));
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $updatedTask = $this->taskRepositoryInterface->updateAndReturnTask($request, $id);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Task updated',
            'data' => [
                'item' => $updatedTask,
            ]
        ], 200);
    }

    /**
     * @param Task $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        $this->taskRepositoryInterface->destroyTask($task);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Task deleted',
        ], 200);
    }

    /**
     * @param Task $task
     * @return ProjectResource
     */
    public function getTaskProject(Task $task){
        return new ProjectResource($this->taskRepositoryInterface->getTaskProject($task));
    }

    public function getTaskUser(Task $task){
        return new UserResource($this->taskRepositoryInterface->getTaskUser($task));
    }
}