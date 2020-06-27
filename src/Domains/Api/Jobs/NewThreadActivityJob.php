<?php

namespace App\Domains\Api\Jobs;

use Framework\IssueThread;
use Framework\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Lucid\Foundation\Job;

class NewThreadActivityJob extends Job
{
    private $t, $d, $a, $s, $m, $r;

    /**
     * Create a new job instance.
     *
     * @param IssueThread $thread
     * @param User|Authenticatable $doer
     * @param string $action
     * @param int $subject
     * @param array $meta
     * @param $ret
     */
    public function __construct($thread, $doer, $action, $subject, $meta = null, $ret = null)
    {
        $this->t = $thread;
        $this->d = $doer;
        $this->a = $action;
        $this->s = $subject;
        $this->m = $meta;
        $this->r = &$ret;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $thread = $this->t;
        $doer = $this->d;
        $action = $this->a;
        $subject = $this->s;
        $meta = json_encode($this->m ?? ['subject' => $subject]);
        try {
            $activity = DB::table('thread_history')->insert([
                'thread_id' => $thread->id,
                'instigator' => $doer->id,
                'action' => $action,
                'meta' => $meta
            ]);
            return $activity;
        } catch (\Exception $e) {
            $this->r = env('APP_ENV') !== 'production' ? ['error' => $e->getMessage(), 'trace' => $e->getTrace()] : ['error' => 'An error has occurred'];
            return false;
        }
    }
}
