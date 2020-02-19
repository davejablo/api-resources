<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['family_id', 'user_id', 'name', 'description', 'expire_date', 'cost', 'is_done',];

    public function family(){
        return $this->belongsTo('App\Family');
    }



    public function user(){
        return $this->belongsTo('App\User');
    }
}
