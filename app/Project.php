<?php

namespace App;

use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use test\Mockery\ReturnTypeObjectTypeHint;
use Illuminate\Database\Eloquent\Builder;

class Project extends Model
{
    protected $fillable = ['name', 'budget'];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function hasAnyUsers(){
        return $this->users()->first() ? true : false;
    }

    public function hasAnyTasks(){
        return $this->tasks()->first() ? true : false;
    }

    public function hasAnyRelations(){
        return ($this->hasAnyTasks() || $this->hasAnyUsers()) ? true : false;
    }

    public function getTasksCost(){
        $cost = $this->tasks()
            ->where('status', 'done')
            ->where('is_done', true)
            ->pluck('task_cost')
            ->sum();
        return number_format($cost, 2);
    }

    public function getAmountOfAllTasks(){
        return $this->tasks()->count();
    }

    public function getAmountOfAssignedUsers(){
        return $this->users()->count();
    }

    public function getAmountOfDoneTasks(){
        return $this->tasks()
            ->where('status', 'done')
            ->where('is_done', true)
            ->count();
    }

    public function getAmountOfInProgressTasks(){
        return $this->tasks()
            ->where('status', 'in_progress')
            ->where('is_done', false)
            ->count();
    }

    public function getAmountOfNaTasks(){
        return $this->tasks()
            ->where('status', 'not_assigned')
            ->where('is_done', false)
            ->count();
    }

    public function getClient(){
        $user = $this->users()
            ->select('id', 'name', 'email')
            ->join('role_user', function ($join) {
                $join->on('users.id', '=', 'role_user.user_id')
                    ->where('role_user.role_id', '=', 4);
            })
            ->get();
        return $user;
    }
}
