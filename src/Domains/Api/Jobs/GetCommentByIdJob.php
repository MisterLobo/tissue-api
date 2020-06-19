<?php

namespace App\Domains\Api\Jobs;

use Framework\Comment;
use Lucid\Foundation\Job;

class GetCommentByIdJob extends Job
{
    private $id, $ret;
    /**
     * Create a new job instance.
     *
     * @param $id
     * @param $ret
     */
    public function __construct($id, &$ret)
    {
        $this->id = $id;
        $this->ret = &$ret;
    }

    /**
     * Execute the job.
     *
     * @return bool|Comment
     */
    public function handle()
    {
        try {
            $comment = Comment::find($this->id);
            $comment->author;
            $comment->thread;
            $comment->votes;
            return $comment;
        } catch (\Exception $e) {
            $this->ret = ['error' => 'error getting comment'.(env('APP_ENV') !== 'production' ? ': '.$e->getMessage() : '')];
            return false;
        }
    }
}
