<?php

namespace App\Domains\Api\Jobs;

use Framework\Issue;
use Framework\Project;
use Framework\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Lucid\Foundation\Job;

class GetIssuesJob extends Job
{
    private $o, $p, $r;

    /**
     * Create a new job instance.
     *
     * @param User|Authenticatable $o
     * @param Project $p
     * @param $r
     */
    public function __construct($o, $p, &$r)
    {
        $this->o = $o;
        $this->p = $p;
        $this->r = &$r;
    }

    /**
     * Execute the job.
     *
     * @return array|bool
     */
    public function handle()
    {
        $issues = [];
        try {
            $owner = $this->o;
            $project = $this->p;
            $issues = $project->issues; //Issue::join('users', 'users.id', '=', 'author_id')->select('issues.*', 'issues.meta->labels as labels', 'issues.meta->assignees as assignees', 'issues.meta->participants as participants')->get();
            foreach ($issues as $issue) {
                //$issue = new Issue();
                $meta = $issue->meta !== null ? json_decode($issue->meta) : [];
                $issue->meta = $meta;
                $issue->labels = $issue->labels !== null ? $meta->labels : [];
                $assignees = $meta->assignees !== null ? User::select('users.*')->whereIn('id', $meta->assignees)->get()->toArray() : [];
                $issue->assignees = $assignees;
                $parts = $issue->participants !== null ? User::select('users.*')->whereIn('id', $meta->participants)->get()->toArray() : [];
                $issue->participants = $parts;
                //$author = User::firstWhere('social_id', $issue->author_id);
                $issue->author;
                $issue->project;
                $issue->thread;
            }
            //$issues = Issue::addSelect(['issues' => User::select('display_name')->whereColumn('social_id', 'issues.author_id')])->get()->toArray();
            //$coll = $issues->load('author_id')->toArray();
            //var_dump($issues);
            return $issues;
        } catch (\Exception $e) {
            $this->r = env('APP_ENV') !== 'production' ? ['error' => $e, 'i' => $issues] : ['error' => 'An error has occurred'];
            return false;
        }
    }
}
