<?php


namespace App\Http\Repositories;

use App\Http\RepositoryInterfaces\TaskRepositoryInterface;
use App\Task;
use App\Http\Resources\TaskResource;

class TaskRepository implements TaskRepositoryInterface
{
    public function createAndReturnTask($request){
        $newTask = Task::create($request->validated());
        if ($newTask->save()){
            return new TaskResource($newTask);
        }
    }

    public function getTasks(){
        return $tasks = Task::all();
    }

    public function getTask($task){
        return $taskToReturn = Task::findOrFail($task->id);
    }

    public function destroyTask($taskToDestroy){
        $taskToDestroy->delete();
    }

    public function updateAndReturnTask($request, $id){
        $taskFromDb = Task::findOrFail($id);
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