<?php

namespace Framework;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'display_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function votes()
    {
        return $this->hasMany('\Framework\Vote', 'voter_id');
    }

    public function comments()
    {
        return $this->hasMany('\Framework\Comment', 'author_id');
    }

    public function projects()
    {
        return $this->hasMany('\Framework\Project', 'owner_id', 'social_id');
    }

    public function threads()
    {
        return $this->hasMany('\Framework\IssueThread', 'author_id', 'social_id');
    }

    public function issues()
    {
        return $this->hasMany('\Framework\Issue', 'author_id', 'social_id');
    }

    public function orgs()
    {
        return $this->morphToMany('\Framework\Organization', 'org_members', 'org_members', 'org_id', 'member_id');
    }
}
