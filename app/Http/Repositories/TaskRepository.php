<?php


namespace App\Http\Repositories;

use App\Http\RepositoryInterfaces\TaskRepositoryInterface;
use App\Task;
use App\Http\Resources\TaskResource;
use App\User;
use Illuminate\Support\Facades\Auth;

class TaskRepository implements TaskRepositoryInterface
{
    public function createAndReturnTask($request){
        if ($user_id = $request->user_id){
            $hours = $request->hours_spent;
            $foundUser = User::find($user_id);
            $newTask = new Task($request->validated());
            $newTask->task_cost = $hours * $foundUser->hr_wage;
            $newTask->save();
        }
        else
            $newTask = Task::create($request->validated());
        if ($newTask->save()){
            return new TaskResource($newTask);
        }
    }

    public function getTasks(){
        return $tasks = Task::paginate(5);
    }

    public function getTask($task){
        return $taskToReturn = Task::findOrFail($task->id);
    }

    public function destroyTask($taskToDestroy){
        $taskToDestroy->delete();
    }

    public function updateAndReturnTask($request, $id){
        $taskFromDb = Task::findOrFail($id);
        if ($hours = $request->hours_spent){
            $taskFromDb->task_cost = $hours * Auth::user()->hr_wage;
            $taskFromDb->update($request->validated());
        }
        else
        $taskFromDb->update($request->validated());
        $updatedTaskFromDb = Task::findOrFail($id);

        return new TaskResource($updatedTaskFromDb);
    }

    public function getTaskProject(Task $task){
        return $taskProject = $task->project()->firstOrFail();
    }

    public function getTaskUser(Task $task){
        return $taskProject = $task->user()->firstOrFail();
    }
}