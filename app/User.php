<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'group_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


//    protected static function boot()
//    {
//        parent::boot();
//
//        static::created(function($user, $request) {
//            $user->profile()->create([
//                'birth_date' => $request->birth_date,
//                'phone' => $request->phone,
//            ]);
//        });
//    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
