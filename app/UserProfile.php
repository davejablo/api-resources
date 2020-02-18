<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'birth_date', 'phone'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
