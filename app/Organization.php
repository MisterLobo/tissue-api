<?php

namespace Framework;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    public function members()
    {
        return $this->morphedByMany('\Framework\User', 'org_members');
    }
}
