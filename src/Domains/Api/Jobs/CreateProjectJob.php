<?php

namespace App\Domains\Api\Jobs;

use Framework\Project;
use Lucid\Foundation\Job;

class CreateProjectJob extends Job
{
    private $project, $ret;

    /**
     * Create a new job instance.
     *
     * @param array $project
     * @param $ret
     */
    public function __construct($project, &$ret)
    {
        $this->project = (array) $project;
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
        $dupe = Project::where(['owner_id' => $project['owner_id'], 'slug' => $project['slug']])->first();
        if ($dupe === null)
        {
            $proj = Project::Create(['owner_id' => $this->project['owner_id'], 'slug' => $this->project['slug'], 'title' => $project['title'], 'description' => $project['description'], 'website' => $project['website'], 'is_public' => $project['is_public']]);
            $proj->owner;
            return ['m' => 'OK', 's' => 200, 'p' => $proj];
        } else {
            $this->ret = 'Project already exists';
            return false;
        }
    }
}
