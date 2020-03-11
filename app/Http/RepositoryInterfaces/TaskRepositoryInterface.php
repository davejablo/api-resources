<?php

namespace App\Http\RepositoryInterfaces;

use App\Task;

interface TaskRepositoryInterface
{
    public function createAndReturnTask($request);

    public function getTasks();

    public function getTask($task);

    public function destroyTask($taskToDestroy);

    public function updateAndReturnTask($request, $id);

    public function getTaskProject(Task $task);

    public function getTaskUser(Task $task);
}