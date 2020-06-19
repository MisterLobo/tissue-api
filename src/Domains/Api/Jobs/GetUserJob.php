<?php

namespace App\Domains\Api\Jobs;

use Framework\User;
use Lucid\Foundation\Job;

class GetUserJob extends Job
{
    private $u, $ret, $loadall;

    /**
     * Create a new job instance.
     *
     * @param $u
     * @param $ret
     * @param bool $loadall
     */
    public function __construct($u, &$ret, $loadall = false)
    {
        $this->u = $u;
        $this->ret = &$ret;
        $this->loadall = $loadall;
    }

    /**
     * Execute the job.
     *
     * @return User|bool
     */
    public function handle()
    {
        try {
            $user = is_string($this->u) ? User::where('display_name', $this->u)->firstOrFail() : User::findOrFail($this->u);
            if ($this->loadall) {
                $user->votes;
                $user->comments;
                $user->projects;
                $user->threads;
                $user->issues;
            }
            return $user;
        } catch (\Exception $e) {
            $this->ret = ['error' => 'error in user '.$this->u.': '.$e->getMessage()];
            return false;
        }

    }
}
