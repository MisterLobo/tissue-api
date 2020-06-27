<?php

namespace App\Domains\Api\Jobs;

use Framework\Project;
use Framework\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Lucid\Foundation\Job;

class CreateUserProjectJob extends Job
{
    private $project, $user, $ret;

    /**
     * Create a new job instance.
     *
     * @param array $project
     * @param User|Authenticatable $user
     * @param $ret
     */
    public function __construct($project, $user, &$ret)
    {
        $this->project = (array) $project;
        $this->user = $user;
        $this->ret = &$ret;
    }

    /**
     * Execute the job.
     *
     * @return array|bool
     */
    public function handle()
    {
        $project = $this->project;
        $ret = [];
        $dupe = Project::where(['owner_id' => $this->user->id, 'slug' => $project['slug']])->first();
        if ($dupe === null)
        {
            $proj = Project::Create(['owner_id' => $this->user->id, 'slug' => $this->project['slug'], 'title' => $project['title'], 'description' => $project['description'], 'website' => $project['website'], 'is_public' => $project['is_public'], 'owner_type' => 'user']);
            $proj->owner;
            $proj->members;
            return $proj;
        } else {
            $this->ret = 'Project already exists';
            return false;
        }
    }
}
