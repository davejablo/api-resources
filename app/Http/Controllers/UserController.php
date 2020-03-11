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

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    public function postLogout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'User logged out'
        ], 200);
    }

    public function register(RegisterUserRequest $request)
    {
        $user = $this->userRepository->createAndReturnUser($request);
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'code' => 201,
            'status' => 'success',
            'message' => 'User registered',
            'data' => [
                'item' => $user,
                'token' => $token
            ]
        ], 201);
    }

    public function getAuthenticatedUser()
    {
        return new UserResource($this->userRepository->getAuthenticatedUser()->load('project', 'tasks', 'profile'));
    }

    public function getUserProject(){
        return new ProjectResource($this->userRepository->getUserProject());
    }

    public function getUserTasks(){
        return TaskResource::collection($this->userRepository->getUserTasks());
    }

    public function getSingleUserTask(Task $task){
        return new TaskResource($this->userRepository->getSingleUserTask($task));
    }
}