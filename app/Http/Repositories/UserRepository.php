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
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return $user;
    }

    public function createAndReturnUser($request){
        $newUser = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'group_id' => $request->get('group_id')
        ]);

        if ($newUser->save()){
            return $newUser;
        }
    }

    public function getUserGroup(){
        return $userGroup = $this->getAuthenticatedUser()->group;
    }

    public function getUserTasks(){
        return $userTasks = $this->getAuthenticatedUser()->tasks;
    }

    public function getSingleUserTask(Task $task){
        $user = $this->getAuthenticatedUser();
        return $userSingleTask = $user->tasks()->where('id', $task->id)->firstOrFail();
    }
}