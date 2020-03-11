<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'name',
        'description',
        'expire_date',
        'time_spent',
        'task_cost',
        'status',
        'is_done',
    ];

    const TASK_STATUS = ['not_assigned', 'in_progress', 'done'];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function hasProject(){
        return $this->project()->first() ? true : false;
    }

    public function hasUser(){
        return $this->user()->first() ? true : false;
    }

    public function isDone(){
        return $this->is_done ? true : false;
    }
}
