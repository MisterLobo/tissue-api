<?php

namespace App\Domains\Api\Jobs;

use Lucid\Foundation\Job;

class UpdateVoteJob extends Job
{
    private $id, $vote, $ret;
    /**
     * Create a new job instance.
     *
     * @param $id
     * @param $vote
     * @param $ret
     */
    public function __construct($id, $vote, &$ret)
    {
        $this->id = $id;
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
        //
    }
}
