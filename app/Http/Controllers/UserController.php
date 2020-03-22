<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserResource;
use App\Project;
use App\Task;
use App\User;
use App\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $this->authorize('view', User::class);
        return UserResource::collection($this->userRepository->getUsers());
    }

    /**
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        $this->authorize('view', User::class);
        return new UserResource($this->userRepository->getUser($user)->load('roles'));
    }

    public function getUserProfile(User $user){
        $this->authorize('view', User::class);
        return new UserProfileResource($this->userRepository->getUserProfile($user));
    }

    public function getSingleUserTask(User $user, Task $task){
        $this->authorize('view', User::class);
        return new TaskResource ($this->userRepository->getSingleUserTask($user, $task));
    }

    public function getUserProject(User $user){
        $this->authorize('view', User::class);
        return new ProjectResource($this->userRepository->getUserProject($user));
    }

    public function getAuthenticatedProject(){
        return new ProjectResource($this->userRepository->getAuthenticatedProject());
    }

    public function getAuthenticatedProfile(){
        return new UserProfileResource($this->userRepository->getAuthenticatedProfile());
    }

    public function getUserTasks(User $user){
        return TaskResource::collection($this->userRepository->getUserTasks($user));
    }

    public function getSingleAuthenticatedTask(Task $task){
        return new TaskResource($this->userRepository->getSingleAuthenticatedTask($task));
    }
}