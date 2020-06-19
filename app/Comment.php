<?php

namespace Framework;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['thread_id', 'author_id', 'parent_id', 'depth', 'content', 'upvotes', 'downvotes'];

    public function thread()
    {
        return $this->belongsTo('\Framework\IssueThread');
    }

    public function votes()
    {
        return $this->hasMany('\Framework\Vote');
    }

    public function author()
    {
        return $this->belongsTo('\Framework\User', 'author_id', 'social_id');
    }
}
