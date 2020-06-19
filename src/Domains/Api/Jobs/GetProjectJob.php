<?php

namespace App\Domains\Api\Jobs;

use Framework\Project;
use Framework\User;
use Lucid\Foundation\Job;

class GetProjectJob extends Job
{
    private $owner, $slug, $ret;

    /**
     * Create a new job instance.
     *
     * @param User $owner
     * @param $slug
     * @param $ret
     */
    public function __construct($owner, $slug, &$ret)
    {
        $this->owner = $owner;
        $this->slug = $slug;
        $this->ret = &$ret;
    }

    /**
     * Execute the job.
     *
     * @return bool|Project
     */
    public function handle()
    {
        try {
            $owner = $this->owner;
            $slug = $this->slug;
            $project = Project::where('owner_id', $owner->social_id)->where('slug', $slug)->firstOrFail();
            $project->owner;
            $project->threads;
            $project->issues;
        } catch (\Exception $e) {
            $this->ret = ['error' => 'error getting project'.(env('APP_ENV') !== 'production' ? ': '.$e->getMessage() : '')];
            return false;
        }
    }
}
