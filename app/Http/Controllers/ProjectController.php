<?php

namespace App\Http\Controllers;

use App\Http\Requests\Document\StoreDocumentRequest;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\DocumentResource;
use App\Project;
use App\Http\RepositoryInterfaces\ProjectRepositoryInterface;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserResource;
use App\Task;
use App\User;
use http\QueryString;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class ProjectController extends Controller
{
    protected $projectRepositoryInterface;
    protected $auth;
    const RESULTS = [5, 15, 25, 50, 75, 100];

    public function __construct(ProjectRepositoryInterface $projectInterface, Auth $auth)
    {
        $this->projectRepositoryInterface = $projectInterface;
        $this->auth = $auth;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny',Project::class);
        if (request()->query())
        {
            request()->validate([
                'results' => [
                    'required',
                    'integer',
                    Rule::in(self::RESULTS)
                ]
            ]);
            $results = request()->get('results');
            return ProjectResource::collection($this->projectRepositoryInterface->getProjects($results));
        }
        else
        return ProjectResource::collection($this->projectRepositoryInterface->getAllProjects());
//        return ProjectResource::collection($this->projectRepositoryInterface->getProjects()->load('tasks','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param StoreProjectRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreProjectRequest $request)
    {
        $authUser = $this->auth->user();
        $this->authorize('create', $authUser, Project::class);
        $newProject = $this->projectRepositoryInterface->createAndReturnProject($request);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Project added',
            'data' => [
                'item' => $newProject
            ]
        ], 200);
    }

    /**
     * @param Project $project
     * @return ProjectResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Project $project)
    {
        $authUser = $this->auth->user();
        $this->authorize('view', $project, Project::class);
        if (request()->query())
        {
            request()->validate([
                'date_start' => 'required|date|before_or_equal:today',
                'date_end' => 'required|date|after:date_start',
            ]);
            return new ProjectResource($this->projectRepositoryInterface->getProject($project));
        }
        else
        return new ProjectResource($this->projectRepositoryInterface->getProject($project));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param UpdateProjectRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateProjectRequest $request, $id)
    {
        $authUser = $this->auth->user();
        $this->authorize('update', $authUser->project, Project::class);
        $updatedProject = new ProjectResource($this->projectRepositoryInterface->updateAndReturnProject($request, $id));

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Project updated',
            'data' => [
                'item' => $updatedProject,
            ]
        ], 200);
    }

    /**
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Project $project)
    {
        $authUser = $this->auth->user();
        $this->authorize('delete', $authUser->project, Project::class);
        if ($project->hasAnyRelations()){
            return response()->json([
                'code' => 409,
                'status' => 'conflict',
                'message' => 'Project cannot be deleted because it has child items',
            ], 409);
        }
            $this->projectRepositoryInterface->destroyProject($project);
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Project deleted',
            ], 200);
    }

    /**
     * @param Project $project
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getProjectTasks(Project $project)
    {
        $this->authorize('view', $project, Project::class);
        return TaskResource::collection($this->projectRepositoryInterface->getProjectTasks($project));
    }

    /**
     * @param Project $project
     * @param Task $task
     * @return TaskResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getSingleProjectTask(Project $project, Task $task){
        $this->authorize('view', $project, Project::class);
        return new TaskResource($this->projectRepositoryInterface->getSingleProjectTask($project, $task));
    }

    /**
     * @param Project $project
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getProjectUsers(Project $project)
    {
        $authUser = $this->auth->user();
        $this->authorize('view', $authUser->project);
        return UserResource::collection($this->projectRepositoryInterface->getProjectUsers($project));
    }

    /**
     * @param Project $project
     * @param User $user
     * @return UserResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getSingleProjectUser(Project $project, User $user){
        $authUser = $this->auth->user();
        $this->authorize('view', $authUser->project, Project::class);
        return new UserResource($this->projectRepositoryInterface->getSingleProjectUser($project, $user));
    }

    /**
     * @param Project $project
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getProjectDocuments(Project $project)
    {
        $this->authorize('view', $project, Project::class);
        return DocumentResource::collection($this->projectRepositoryInterface->getProjectDocuments($project));
    }

}