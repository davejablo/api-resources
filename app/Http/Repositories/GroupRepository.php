<?php

namespace App\Http\Repositories;

use App\Group;
use App\Http\RepositoryInterfaces\GroupRepositoryInterface;
use App\Http\Resources\GroupResource;
use App\Task;
use App\User;

class GroupRepository implements GroupRepositoryInterface
{
    public function createAndReturnGroup($request){
        $group = Group::create($request->validated());
        if ($group->save()){
            return new GroupResource($group);
        }
    }

    public function getGroups(){
        return $groups = Group::all();
    }

    public function getGroup($group){
        return $GroupToReturn = Group::findOrFail($group);
    }

    public function destroyGroup($groupToDestroy){
        $groupToDestroy->delete();
    }

    public function updateAndReturnGroup($request, $id){
        $groupFromDb = Group::findOrFail($id);
        return $groupToReturn = $groupFromDb->update($request->validated());
    }

    public function getGroupTasks(Group $group)
    {
        return $groupTasks = $group->tasks()->get();
    }

    public function getSingleGroupTask(Group $group, Task $task)
    {
        return $singleGroupTask = $group->tasks()->where('id', $task->id)->firstOrFail();
    }

    public function getGroupUsers(Group $group)
    {
        return $groupUsers = $group->users()->get();
    }

    public function getSingleGroupUser(Group $group, User $user)
    {
        return $singleGroupUser = $group->users()->where('id', $user->id)->firstOrFail();
    }
}