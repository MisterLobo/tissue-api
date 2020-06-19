<?php

namespace App\Domains\Api\Jobs;

use Framework\Issue;
use Framework\IssueThread;
use Framework\Project;
use Framework\User;
use Lucid\Foundation\Job;

class GetThreadJob extends Job
{
    private $id, $i, $p, $a, $o, $ret;

    /**
     * Create a new job instance.
     *
     * @param int $id
     * @param Issue|null $issue
     * @param Project|null $project
     * @param User|null $author
     * @param User|null $owner
     * @param $ret
     */
    public function __construct($id, $issue = null, $project = null, $author = null, $owner = null, &$ret = null)
    {
        $this->id = $id;
        $this->i = $issue;
        $this->p = $project;
        $this->a = $author;
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
            $id = $this->id;
            $thread = IssueThread::find($id);
            $thread->comments;
            foreach ($thread->comments as $comment) {
                $comment->author;
            }
            //var_dump($thread);
            return $thread;
        } catch (\Exception $e) {
            $this->ret = ['error' => 'Error in thread'];
            return false;
        }
    }
}
