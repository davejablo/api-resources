<?php

namespace App\Http\RepositoryInterfaces;

use App\Group;
use App\Task;
use App\User;

interface GroupRepositoryInterface
{
    public function createAndReturnGroup($request);

    public function getGroups();

    public function getGroup($group);

    public function destroyGroup($groupToDestroy);

    public function updateAndReturnGroup($request, $id);

    public function getGroupTasks(Group $group);

    public function getSingleGroupTask(Group $group, Task $task);

    public function getGroupUsers(Group $group);

    public function getSingleGroupUser(Group $group, User $user);
}