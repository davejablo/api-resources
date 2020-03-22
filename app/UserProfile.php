<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'birth_date', 'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAge(){
        return $age = Carbon::parse($this->birth_date)->age;
    }

    public function getAmountOfDoneTasks(){
        $doneTasks = User::withCount([
            'tasks as done_tasks_count' => function (Builder $query) {
                $query->where([
                    ['status', '=', 'done'],
                    ['is_done', '=', true]
                    ]);
            }
        ])->get();
        return $doneTasks[0]->done_tasks_count;
    }

    public function getAmountOfInProgressTasks(){
        $inProgressTasks = User::withCount([
            'tasks as in_progress_tasks_count' => function (Builder $query) {
                $query->where([
                    ['status', '=', 'in_progress'],
                    ['is_done', '=', false]
                ]);
            }
        ])->get();
        return $inProgressTasks[0]->in_progress_tasks_count;
    }
}
