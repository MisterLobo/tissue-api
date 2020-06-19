<?php

namespace App\Domains\Api\Jobs;

use Framework\Vote;
use Lucid\Foundation\Job;

class AddOrUpdateVoteJob extends Job
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
     * @return bool|Vote
     */
    public function handle()
    {
        try {
            $vote = Vote::updateOrCreate(['comment_id' => $this->cid, 'voter_id' => $this->uid], ['vote' => $this->vote]);
            $vote->voter;
            $vote->comment;
            return $vote;
        } catch (\Exception $e) {
            $this->ret = ['error' => ('error in vote' . env('APP_ENV') !== 'production') ? ': '.$e->getMessage() : ''];
            return false;
        }
    }
}
