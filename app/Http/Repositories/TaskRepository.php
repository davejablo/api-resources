<?php


namespace App\Http\Repositories;

use App\Task;
use App\Http\Resources\TaskResource;

class TaskRepository
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
        return $taskToReturn = Task::findOrFail($task);
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

    public function getTaskGroup(Task $task){
        return $taskGroup = $task->group()->firstOrFail();
    }

    public function getTaskUser(Task $task){
        return $taskGroup = $task->user()->firstOrFail();
    }
}