<?php


namespace App\Http\Repositories;
use App\Http\Resources\UserResource;
use App\Task;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function getAuthenticatedUser(){
        return $user = auth()->user();
    }

    public function createAndReturnUser($request){
        $newUser = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'project_id' => $request->get('project_id')
        ]);

        if ($newUser->save()){
            return $newUser;
        }
    }

    public  function getUsers(){
        return $users = User::all();
    }

    public function getUser($user){
        return $userToReturn = User::findOrFail($user->id);
    }

    public function getUserProfile(User $user){
        return $userProfile = $user->profile()->firstOrFail();
    }

    public function getAuthenticatedProject(){
        return $userProject = $this->getAuthenticatedUser()->project()->firstOrFail();
    }

    public function getUserProject(User $user){
        return $userProject = $user->project()->firstOrFail();
    }

    public function getUserTasks(User $user){
        return $userTasks = $user->tasks()->get();
    }

    public function getSingleUserTask(User $user, Task $task){
        return $singleUserTask = $user->tasks()->where('id', $task->id)->firstOrFail();
    }

    public function getAuthenticatedProfile(){
        return $userProfile = $this->getAuthenticatedUser()->profile()->firstOrFail();
    }

    public function getAuthenticatedTasks(){
        return $userTasks = $this->getAuthenticatedUser()->tasks()->get();
    }

    public function getSingleAuthenticatedTask(Task $task){
        $user = $this->getAuthenticatedUser();
        return $userSingleTask = $user->tasks()->where('id', $task->id)->firstOrFail();
    }
}