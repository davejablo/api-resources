<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\RepositoryInterfaces\GroupRepositoryInterface;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserResource;
use App\Task;
use App\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    protected $groupRepositoryInterface;

    public function __construct(GroupRepositoryInterface $repositoryInterface)
    {
        $this->groupRepositoryInterface = $repositoryInterface;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return GroupResource::collection($this->groupRepositoryInterface->getGroups()->load('tasks'));
        return GroupResource::collection($this->groupRepositoryInterface->getGroups());
//        return GroupResource::collection($this->groupRepositoryInterface->getGroups()->load('tasks','users'));
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
     * @param StoreGroupRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreGroupRequest $request)
    {
        $newGroup = $this->groupRepositoryInterface->createAndReturnGroup($request);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Group added',
            'data' => [
                'item' => $newGroup
            ]
        ], 200);
    }

    /**
     * @param Group $group
     * @return GroupResource
     */
    public function show(Group $group)
    {
        return new GroupResource($this->groupRepositoryInterface->getGroup($group));
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
     * @param UpdateGroupRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateGroupRequest $request, $id)
    {
        $updatedGroup = new GroupResource($this->groupRepositoryInterface->updateAndReturnGroup($request, $id));

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Group updated',
            'data' => [
                'item' => $updatedGroup,
            ]
        ], 200);
    }

    /**
     * @param Group $group
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Group $group)
    {
        if ($group->hasAnyRelations()){
            return response()->json([
                'code' => 409,
                'status' => 'conflict',
                'message' => 'Group cannot be deleted because it has child items',
            ], 409);
        }
            $this->groupRepositoryInterface->destroyGroup($group);
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Group deleted',
            ], 200);
    }

    /**
     * @param Group $group
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getGroupTasks(Group $group)
    {
        return TaskResource::collection($this->groupRepositoryInterface->getGroupTasks($group));
    }

    /**
     * @param Group $group
     * @param Task $task
     * @return TaskResource
     */
    public function getSingleGroupTask(Group $group, Task $task){
        return new TaskResource($this->groupRepositoryInterface->getSingleGroupTask($group, $task));
    }

    /**
     * @param Group $group
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getGroupUsers(Group $group)
    {
        return UserResource::collection($this->groupRepositoryInterface->getGroupUsers($group));
    }

    /**
     * @param Group $group
     * @param User $user
     * @return UserResource
     */
    public function getSingleGroupUser(Group $group, User $user){
        return new UserResource($this->groupRepositoryInterface->getSingleGroupUser($group, $user));
    }
}
