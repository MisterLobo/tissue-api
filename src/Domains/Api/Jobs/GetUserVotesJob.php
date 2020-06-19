<?php

namespace App\Domains\Api\Jobs;

use Lucid\Foundation\Job;

class GetUserVotesJob extends Job
{
    private $u, $ret;
    /**
     * Create a new job instance.
     *
     * @param $u
     * @param $ret
     */
    public function __construct($u, &$ret)
    {
        $this->u = $u;
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
            $user = $this->u;
            $user->votes;
            return $user;
        } catch (\Exception $e) {
            $this->ret = ['error' => 'error in votes'.(env('APP_ENV') !== 'production' ? ': '.$e->getMessage() : '')];
            return false;
        }
    }
}
