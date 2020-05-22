<?php

namespace App\Http\RepositoryInterfaces;

use App\Project;
use App\Task;
use App\User;

interface ProjectRepositoryInterface
{
    public function createAndReturnProject($request);

    public function getProjects($results);

    public function getAllProjects();

    public function getProject($project);

    public function destroyProject($projectToDestroy);

    public function updateAndReturnProject($request, $id);

    public function getProjectTasks(Project $project);

    public function getSingleProjectTask(Project $project, Task $task);

    public function getProjectUsers(Project $project);

    public function getSingleProjectUser(Project $project, User $user);

    public function getProjectDocuments(Project $project);
}