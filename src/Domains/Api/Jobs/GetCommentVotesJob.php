<?php

namespace App\Domains\Api\Jobs;

use Framework\Comment;
use Framework\Vote;
use Lucid\Foundation\Job;

class GetCommentVotesJob extends Job
{
    private $cmt, $ret;
    /**
     * Create a new job instance.
     *
     * @param $cmt
     * @param $ret
     */
    public function __construct($cmt, &$ret)
    {
        $this->cmt = $cmt;
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
            $comment = $this->cmt;
            $comment->votes;
            $comment->upvotes = Vote::where(['comment_id' => $comment->id, 'vote' => 'up'])->count();
            $comment->downvotes = Vote::where(['comment_id' => $comment->id, 'vote' => 'down'])->count();
            return $comment;
        } catch (\Exception $e) {
            $this->ret = [];
            return false;
        }
    }
}
