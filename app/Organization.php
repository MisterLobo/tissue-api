<?php

namespace Framework;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public function members()
    {
        return $this->belongsToMany('\Framework\User', 'org_members', 'org_id', 'member_id');
    }
}
