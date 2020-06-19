<?php

namespace App\Domains\Api\Jobs;

use Framework\Vote;
use Lucid\Foundation\Job;

class CreateVoteJob extends Job
{
    private $uid, $cid, $vote, $ret;
    /**
     * Create a new job instance.
     *
     * @param $uid
     * @param $cid
     * @param $vote
     * @param $ret
     */
    public function __construct($uid, $cid, $vote, &$ret)
    {
        $this->uid = $uid;
        $this->cid = $cid;
        $this->vote = $vote;
        $this->ret = &$ret;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $vote = Vote::create(['comment_id' => $this->cid, 'voter_id' => $this->uid, 'vote' => $this->vote]);
        $vote->voter;
        $vote->comment;
        return $vote;
    }
}
