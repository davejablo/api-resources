<?php

namespace App\Policies;

use App\Project;
use App\Task;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tasks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the task.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->hasAnyRoles(['ADMIN', 'WORKER', 'LEADER', 'CLIENT']);
    }

    /**
     * Determine whether the user can create tasks.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAnyRoles(['ADMIN', 'LEADER', 'CLIENT']);
    }

    /**
     * Determine whether the user can update the task.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function update(User $user, Task $task)
    {
        switch ($user){
            case $user->hasRole('ADMIN'):
                return true;
                break;

            case $user->hasRole(['LEADER']):
                return $user->project_id == $task->project_id;
                break;

            case $user->hasRole('WORKER'):
                return $user->project_id == $task->project_id && $user->id == $task->user_id;
                break;

            case $user->hasRole('CLIENT'):
                return $user->project_id == $task->project_id;
                break;

            default:
                return false;
        }
    }

    /**
     * Determine whether the user can delete the task.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function delete(User $user, Task $task)
    {
        switch ($user) {
            case $user->hasRole('ADMIN'):
                return true;
                break;

            case $user->hasAnyRoles(['LEADER', 'CLIENT']):
                return $user->project_id == $task->project_id;
                break;
            default:
                return false;
        }
    }

    /**
     * Determine whether the user can restore the task.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function restore(User $user, Task $task)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the task.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function forceDelete(User $user, Task $task)
    {
        //
    }
}
