<?php

namespace App\Domains\Api\Jobs;

use Framework\Issue;
use Framework\IssueThread;
use Framework\Project;
use Framework\User;
use Lucid\Foundation\Job;

class GetThreadJob extends Job
{
    private $i, $p, $o, $ret;

    /**
     * Create a new job instance.
     *
     * @param Issue|null $issue
     * @param Project|null $project
     * @param User|null $owner
     * @param $ret
     */
    public function __construct($issue, $project, $owner, &$ret = null)
    {
        $this->i = $issue;
        $this->p = $project;
        $this->o = $owner;
        $this->ret = &$ret;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        try {
            $issue = $this->i;
            $project = $this->p;
            $owner = $this->o;
            $thread = IssueThread::where('project_id', $project->id)->where('author_id', $owner->id)->where('issue_id', $issue->id)->first();
            $thread->comments;
            $thread->issue;
            $thread->labels = $issue->meta->labels;
            $thread->assignees = User::select('users.*')->whereIn('id', $issue->meta->assignees)->get()->toArray();
            $thread->participants = User::select('users.*')->whereIn('id', $issue->meta->participants)->get()->toArray();
            foreach ($thread->comments as $comment) {
                $comment->author;
            }
            //var_dump($thread);
            return $thread;
        } catch (\Exception $e) {
            $this->ret = env('APP_ENV') !== 'production' ? ['error' => $e->getMessage(), 'trace' => $e->getTrace()] : ['error' => 'An error has occurred'];
            return false;
        }
    }
}
