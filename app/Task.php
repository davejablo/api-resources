<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'group_id',
        'user_id',
        'name',
        'description',
        'expire_date',
        'cost',
        'status',
        'is_done',
    ];

    const TASK_STATUS = ['not_assigned', 'in_progress', 'done'];

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function hasGroup(){
        return $this->group()->first() ? true : false;
    }

    public function hasUser(){
        return $this->user()->first() ? true : false;
    }

    public function isDone(){
        return $this->is_done ? true : false;
    }
}
