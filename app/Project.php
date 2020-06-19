<?php

namespace Framework;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string slug
 * @property int owner_id
 * @property string website
 * @property string description
 * @property string title
 * @property bool is_public
 */
class Project extends Model
{
    protected $fillable = ['owner_id', 'title', 'slug', 'description', 'website', 'is_public'];

    public function issues()
    {
        return $this->hasMany('\Framework\Issue', 'project_id');
    }

    public function threads()
    {
        return $this->hasMany('\Framework\IssueThread', 'project_id');
    }

    public function owner()
    {
        return $this->belongsTo('\Framework\User', 'owner_id', 'social_id');
    }
}
