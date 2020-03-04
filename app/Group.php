<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use test\Mockery\ReturnTypeObjectTypeHint;

class Group extends Model
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
}
