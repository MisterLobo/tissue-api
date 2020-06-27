<?php

namespace App\Domains\Api\Jobs;

use Carbon\Traits\Converter;
use Framework\Issue;
use Framework\IssueThread;
use Framework\Project;
use Framework\User;
use Framework\Vote;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Lucid\Foundation\Job;

class GetIssueJob extends Job
{
    private $o, $p, $i, $ret;

    /**
     * Create a new job instance.
     *
     * @param User|Authenticatable $o
     * @param Project $p
     * @param int $i
     * @param mixed $ret
     */
    public function __construct($o, $p, $i, &$ret)
    {
        $this->o = $o;
        $this->p = $p;
        $this->i = $i;
        $this->ret = &$ret;
    }

    /**
     * Execute the job.
     *
     * @return array|bool
     */
    public function handle()
    {
        try {
            //$owner = $this->o;
            //$project = $this->p;
            $issue = Issue::findOrFail($this->i);
            //$thread = IssueThread::where('issue_id', $issue->id)->where('project_id', $project->id)->firstOrFail();
            $meta = $issue->meta !== null ? json_decode($issue->meta) : [];
            $issue->meta = $meta;
            //$issue->labels = $meta->labels !== null ? $meta->labels : [];
            //$issue->meta = $meta;
            //$assignees = $meta->assignees; // !== null ? User::select('users.*')->whereIn('id', $assignees)->get()->toArray() : [];
            //$issue->assignees = $assignees;
            //$parts = $meta->participants; // !== null ? User::select('users.*')->whereIn('id', $meta->participants)->get()->toArray() : [];
            //$issue->participants = $parts;
            $issue->author;
            $issue->project;
            $issue->project->owner;
            $thread = $issue->thread;
            $thread->author;
            foreach ($thread->comments as $comment) {
                $comment->author;
                $comment->votes;
                $comment->upvotes = Vote::where(['comment_id' => $comment->id, 'vote' => 'up'])->count();
                $comment->downvotes = Vote::where(['comment_id' => $comment->id, 'vote' => 'down'])->count();
            }
            return $issue;
        } catch (ModelNotFoundException $e) {
            $this->ret = ['error' => 'Issue not found', 'message' => $e->getMessage(), 'status' => 404];
            return false;
        } catch (\Exception $e) {
            $this->ret = env('APP_ENV') !== 'production' ? ['error' => $e->getMessage(), 'trace' => $e->getTrace()] : ['error' => 'An error has occurred'];
            return false;
        }
    }
}
