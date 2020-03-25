<?php

namespace App\Http\Controllers;

use App\Http\Repositories\TaskRepository;
use App\Http\Repositories\UserRepository;
use App\Http\RepositoryInterfaces\TaskRepositoryInterface;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserResource;
use App\Task;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Providers\Auth;


class TaskController extends Controller
{
    protected $taskRepositoryInterface;
    protected $userRepository;
    protected $auth;

    public function __construct(TaskRepositoryInterface $taskInterface, UserRepository $userRepository, Auth $auth)
    {
        $this->taskRepositoryInterface = $taskInterface;
        $this->userRepository = $userRepository;
        $this->auth = $auth;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Task::class);
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreTaskRequest $request)
    {
        $this->authorize('create', Task::class);
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task, Task::class);
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('update', $task, Task::class);
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task, Task::class);
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getTaskProject(Task $task){
        $this->authorize('view', $task, Task::class);
        return new ProjectResource($this->taskRepositoryInterface->getTaskProject($task));
    }

    /**
     * @param Task $task
     * @return UserResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getTaskUser(Task $task){
        $this->authorize('view', $task, Task::class);
        return new UserResource($this->taskRepositoryInterface->getTaskUser($task));
    }
}