<?php

namespace App\Domains\Api\Jobs;

use Framework\Comment;
use Framework\Issue;
use Framework\IssueThread;
use Framework\User;
use Lucid\Foundation\Job;

class CreateIssueThreadJob extends Job
{
    private $iss, $m_return;

    /**
     * Create a new job instance.
     *
     * @param Issue $iss
     * @param $ret
     */
    public function __construct($iss, &$ret)
    {
        $this->iss = $iss;
        $this->m_return = $ret;
    }

    /**
     * Execute the job.
     *
     * @return bool|Comment
     */
    public function handle()
    {
        try {
            $issue = $this->iss;
            $author_id = $issue->author_id;
            $user = User::firstWhere('social_id', $author_id);
            $thread = IssueThread::create(['issue_id' => $issue->id, 'project_id' => $issue->project_id, 'author_id' => $author_id, 'meta' => $issue->meta]);
            $thread->author;
            $meta = json_decode($issue->meta);
            $thread->labels = $meta->labels;
            $assignees = $meta->assignees !== null ? User::select('users.*')->whereIn('social_id', $meta->participants)->get()->toArray() : [];
            $thread->assignees = $assignees;
            $parts = $issue->participants !== null ? User::select('users.*')->whereIn('social_id', $meta->participants)->get()->toArray() : [];
            $thread->participants = $parts;
            return $thread;
        } catch (\Exception $e) {
            if (env('APP_ENV') !== 'development' && env('APP_ENV') !== 'local') $this->m_return = ['error' => $e->getMessage()];
            else  $this->m_return = ['error' => 'Error in thread', 'trace' => $e];
            return false;
        }
    }
}
