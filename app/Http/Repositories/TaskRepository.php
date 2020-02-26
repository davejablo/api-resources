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

    public function updateAndReturnTask($request, $id){
        $taskFromDb = Task::findOrFail($id);
        $taskToReturn = $taskFromDb->update($request->validated());
        $taskFromDbv2 = Task::findOrFail($id);

        //Trzeba pobrać jeszcze raz z bazy xDDDD

        return new TaskResource($taskFromDbv2);

//        $taskToUpdate = $this->getTaskById($id);
//        $taskToUpdate->name = $request->name;
    }
}