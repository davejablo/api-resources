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
//        return $taskToReturn = Task::findOrFail($id);
    }

    public function destroyTask($taskToDestroy){
        $taskToDestroy->delete();
    }

    public function updateAndReturnTask($request, $task){
        $taskToReturn = $task->update($request->validated());
        return new TaskResource($taskToReturn);

//        $taskToUpdate = $this->getTaskById($id);
//        $taskToUpdate->name = $request->name;
    }

}