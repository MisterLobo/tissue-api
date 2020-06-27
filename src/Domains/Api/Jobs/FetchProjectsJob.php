<?php

namespace App\Domains\Api\Jobs;

use Framework\Issue;
use Framework\Project;
use Framework\User;
use Illuminate\Support\Facades\Auth;
use Lucid\Foundation\Job;

class FetchProjectsJob extends Job
{
    private $owner, $ownerId, $ret;

    /**
     * Create a new job instance.
     *
     * @param string $owner
     * @param integer $ownerId
     */
    public function __construct($owner, $ownerId, &$ret)
    {
        $this->owner = $owner;
        $this->ownerId = $ownerId;
        $this->ret = &$ret;
    }

    /**
     * Execute the job.
     *
     * @return array|bool
     */
    public function handle()
    {
        //$projects = Project::where('owner_id', $this->ownerId)->get()->toArray();
        //var_dump($projects);
        try {
            //$projects = User::firstWhere('display_name', $this->owner)->projects;
            $projects = Project::where('owner_id', $this->owner->id)->get();
            foreach ($projects as $project) {
                $project->owner;
                $latest_issue = Issue::latest()->first();
                if ($latest_issue !== null) {
                    $latest_issue->author;
                    $project->latest_issue = $latest_issue;
                }
            }
            return ['projects' => $projects];
        } catch (\Exception $e) {
            $this->ret = ['error' => $e->getMessage(), 'status' => 403];
            return false;
        }
    }
}
