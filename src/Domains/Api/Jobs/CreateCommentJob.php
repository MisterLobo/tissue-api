<?php

namespace App\Domains\Api\Jobs;

use Exception;
use Framework\Comment;
use Framework\Issue;
use Framework\IssueThread;
use Lucid\Foundation\Job;

class CreateCommentJob extends Job
{
    private $iss, $thd, $pld, $m_return;

    /**
     * Create a new job instance.
     *
     * @param $iss
     * @param IssueThread|object|array|int $thd
     * @param $pld
     * @param $ret
     */
    public function __construct($iss, $thd, $pld, &$ret)
    {
        $this->iss = $iss;
        $this->thd = $thd;
        $this->pld = $pld;
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
            $thread = $this->thd;
            $aid = 0;
            $thd = 0;
            if (is_object($thread) || $thread instanceof Issue) {
                $aid = $thread->author_id;
                $thd = $thread->id;
            }
            elseif (is_array($thread)) {
                $aid = $thread['author_id'];
                $thd = $thread['id'];
            }
            elseif (is_numeric($thread)) {
                $thd = IssueThread::findOrFail($thread);
                $aid = $thd->author_id;
            }
            else throw new Exception('Thread has invalid type');
            $payload = $this->pld;
            $comment = Comment::create(['thread_id' => $thread->id, 'author_id' => $thread->author_id, 'parent_id' => 0, 'depth' => 1, 'content' => $payload['body'] ?? '*No description provided*']);
            $comment->author;
            return $comment;
        } catch (Exception $e) {
            $this->m_return = env('APP_ENV') !== 'production' ? ['error' => $e->getMessage(), 'trace' => $e->getTrace()] : ['error' => 'An error has occurred'];
            return false;
        }
    }
}
