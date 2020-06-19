<?php

namespace Framework;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int project_id
 * @property int author_id
 * @property string title
 * @property object meta
 * @property string status
 * @property string description
 * @property array labels
 * @property array assignees
 * @property bool is_public
 * @property int id
 */
class Issue extends Model
{
    protected $fillable = ['project_id', 'author_id', 'title', 'meta', 'status', 'description'];

    public function project()
    {
        return $this->belongsTo('\Framework\Project', 'project_id');
    }

    public function thread()
    {
        return $this->hasOne('\Framework\IssueThread', 'issue_id');
    }

    public function author()
    {
        return $this->belongsTo('\Framework\User', 'author_id', 'social_id');
    }

}
