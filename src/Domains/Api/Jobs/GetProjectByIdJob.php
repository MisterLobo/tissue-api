<?php

namespace App\Domains\Api\Jobs;

use Framework\Issue;
use Framework\Project;
use Lucid\Foundation\Job;

class GetProjectByIdJob extends Job
{
    private $id, $ret;

    /**
     * Create a new job instance.
     *
     * @param int $i
     * @param $r
     */
    public function __construct($i, &$r)
    {
        $this->id = $i;
        $this->ret = &$r;
    }

    /**
     * Execute the job.
     *
     * @return bool|Project
     */
    public function handle()
    {
        try {
            $id = $this->id;
            $proj = Project::findOrFail($id);
            $proj->owner;
            $proj->owners;
            $proj->threads;
            $proj->issues;
            $mem = $proj->members;
            $members = [];
            foreach ($mem as $m) {
                array_push($members, $m->name);
            }
            $proj->members = $members;
            $latest_issue = Issue::where('project_id', $id)->latest()->first();
            if ($latest_issue !== null) {
                $latest_issue->author;
                $proj->latest_issue = $latest_issue;
            }
            return $proj;
        } catch (\Exception $e) {
            $this->ret = ['error' => 'error getting project'.(env('APP_ENV') !== 'production' ? ': '.$e->getMessage() : '')];
            return false;
        }
    }
}
