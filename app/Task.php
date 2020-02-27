<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['group_id', 'user_id', 'name', 'description', 'expire_date', 'cost', 'is_done',];

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
