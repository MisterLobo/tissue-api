<?php

namespace Framework;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['comment_id', 'voter_id', 'vote'];

    public function comment()
    {
        return $this->belongsTo('\Framework\Comment');
    }

    public function voter()
    {
        return $this->belongsTo('\Framework\User', 'voter_id');
    }
}
