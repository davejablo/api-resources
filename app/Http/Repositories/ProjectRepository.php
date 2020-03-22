<?php

namespace App\Http\Repositories;

use App\Project;
use App\Http\RepositoryInterfaces\ProjectRepositoryInterface;
use App\Http\Resources\ProjectResource;
use App\Task;
use App\User;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function createAndReturnProject($request){
        $project = Project::create($request->validated());
        if ($project->save()){
            return new ProjectResource($project);
        }
    }

    public function getProjects(){
        return $projects = Project::all();
    }

    public function getProject($project){
        return $projectToReturn = Project::findOrFail($project->id);
    }

    public function destroyProject($projectToDestroy){
        $projectToDestroy->delete();
    }

    public function updateAndReturnProject($request, $id){

        $projectFromDb = Project::findOrFail($id);
        $projectFromDb->update($request->validated());
        $updatedProjectFromDb = Project::findOrFail($id);

        return new ProjectResource($updatedProjectFromDb);
    }

    public function getProjectTasks(Project $project)
    {
        return $projectTasks = $project->tasks()->get();
    }

    public function getSingleProjectTask(Project $project, Task $task)
    {
        return $singleProjectTask = $project->tasks()->where('id', $task->id)->firstOrFail();
    }

    public function getProjectUsers(Project $project)
    {
        return $projectUsers = $project->users()->get();
    }

    public function getSingleProjectUser(Project $project, User $user)
    {
        return $singleProjectUser = $project->users()->where('id', $user->id)->firstOrFail();
    }
}