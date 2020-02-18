<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'description', 'expire_date', 'cost', 'is_done',];

    public function family(){
        return $this->belongsTo('App\Family');
    }



    public function user(){
        return $this->belongsTo('App\User');
    }
}
