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
        'name', 'email', 'password', 'project_id', 'hr_wage'
    ];

    const ROLES = ['ADMIN', 'LEADER', 'WORKER', 'CLIENT'];

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

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function hasAnyRoles($roles){
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    public function hasRole($role){
        return null !== $this->roles()->where('name', $role)->first();
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class)->where('project_id', $this->project()->pluck('id'));
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function hasProfile(){
        return $this->profile()->first() ? true : false;
    }

    public function hasAnyTasks(){
        return $this->tasks()->first() ? true : false;
    }

    public function hasProject(){
        return $this->project()->first() ? true : false;
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
