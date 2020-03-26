<?php

namespace App;

use Carbon\Carbon;
use function foo\func;
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

    public function getHoursSpent(){
        return Task::all()
            ->where('user_id', $this->getKey('user_id'))
            ->pluck('hours_spent')
            ->sum();
    }

    public function getAmountOfRelatedTasks(){
        return Task::all()
            ->where('user_id', $this->getKey('user_id'))
            ->count();
    }

    public function getAmountOfDoneTasks(){
        return Task::all()
            ->where('user_id', $this->getKey('user_id'))
            ->where('status', 'done')
            ->where('is_done', true)
            ->count();
    }

    public function getAmountOfInProgressTasks(){
        return Task::all()
            ->where('user_id', $this->getKey('user_id'))
            ->where('status', 'in_progress')
            ->where('is_done', false)
            ->count();
    }
}
