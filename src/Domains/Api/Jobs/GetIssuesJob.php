<?php

namespace App\Domains\Api\Jobs;

use Framework\Issue;
use Framework\Project;
use Framework\User;
use Illuminate\Support\Facades\DB;
use Lucid\Foundation\Job;

class GetIssuesJob extends Job
{
    private $o, $p;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($o, $p)
    {
        $this->o = $o;
        $this->p = $p;
    }

    /**
     * Execute the job.
     *
     * @return array
     */
    public function handle()
    {
        $owner = User::firstWhere('display_name', $this->o);
        //var_dump($owner);
        $project = Project::firstWhere('owner_id', $owner->social_id);
        //var_dump($project);
        $issues = DB::table('issues')->join('users', 'users.social_id', '=', 'author_id')->join('projects', 'projects.id', '=', 'project_id')->select('issues.*', 'issues.meta->labels as labels', 'issues.meta->assignees as assignees', 'issues.meta->participants as participants', 'users.social_id as author_id', 'users.display_name as author_name')->get();
        $issues = Issue::join('users', 'users.social_id', '=', 'author_id')->select('issues.*', 'issues.meta->labels as labels', 'issues.meta->assignees as assignees', 'issues.meta->participants as participants')->get();
        foreach ($issues as $issue) {
            //$issue = new Issue();
            $meta = $issue->meta !== null ? json_decode($issue->meta) : [];
            $issue->meta = $meta;
            $issue->labels = $issue->labels !== null ? $meta->labels : [];
            $assignees = $meta->participants !== null ? User::select('users.*')->whereIn('social_id', $meta->participants)->get()->toArray() : [];
            $issue->assignees = $assignees;
            $parts = $issue->participants !== null ? User::select('users.*')->whereIn('social_id', $meta->participants)->get()->toArray() : [];
            $issue->participants = $parts;
            //$author = User::firstWhere('social_id', $issue->author_id);
            $issue->author;
            $issue->project;
            $issue->thread;
        }
        //$issues = Issue::addSelect(['issues' => User::select('display_name')->whereColumn('social_id', 'issues.author_id')])->get()->toArray();
        //$coll = $issues->load('author_id')->toArray();
        //var_dump($issues);
        return ['owner' => $owner, 'project' => $project, 'list' => $issues];
    }
}
