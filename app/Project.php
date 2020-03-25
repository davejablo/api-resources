<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use test\Mockery\ReturnTypeObjectTypeHint;
use Illuminate\Database\Eloquent\Builder;

class Project extends Model
{
    protected $fillable = ['name'];

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
        return $this->tasks()
            ->where('status', 'done')
            ->where('is_done', true)
            ->pluck('task_cost')
            ->sum();
    }

    public function getAmountOfAllTasks(){
        return $this->tasks()->count();
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
}
