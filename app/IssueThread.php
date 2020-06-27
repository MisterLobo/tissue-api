<?php

namespace Framework;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int issue_id
 * @property int project_id
 * @property int author_id
 * @property object meta
 * @property array labels
 * @property array assignees
 * @property array participants
 * @property bool is_locked
 */
class IssueThread extends Model
{
    protected $fillable = ['issue_id', 'project_id', 'author_id', 'meta'];
    public function project()
    {
        return $this->belongsTo('\Framework\Project', 'project_id');
    }
    public function issue()
    {
        return $this->belongsTo('\Framework\Issue', 'issue_id');
    }

    public function author()
    {
        return $this->belongsTo('\Framework\User', 'author_id');
    }

    public function comments()
    {
        return $this->hasMany('\Framework\Comment', 'thread_id');
    }

}
