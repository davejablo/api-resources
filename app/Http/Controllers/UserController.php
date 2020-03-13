<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserResource;
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
        return UserResource::collection($this->userRepository->getUsers());
    }

    /**
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($this->userRepository->getUser($user));
    }

    public function getUserProfile(User $user){
        return new UserProfileResource($this->userRepository->getUserProfile($user));
    }

    public function getUserProject(){
        return new ProjectResource($this->userRepository->getUserProject());
    }

    public function getAuthenticatedProfile(){
        return new UserProfileResource($this->userRepository->getAuthenticatedProfile());
    }

    public function getUserTasks(){
        return TaskResource::collection($this->userRepository->getUserTasks());
    }

    public function getSingleAuthenticatedTask(Task $task){
        return new TaskResource($this->userRepository->getSingleAuthenticatedTask($task));
    }
}