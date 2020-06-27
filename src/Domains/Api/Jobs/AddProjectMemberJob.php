<?php

namespace App\Domains\Api\Jobs;

use Framework\Project;
use Framework\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;
use Lucid\Foundation\Job;

class AddProjectMemberJob extends Job
{
    private $p, $u, $m, $r;

    /**
     * Create a new job instance.
     *
     * @param Project $p
     * @param User|Authenticatable $u
     * @param array $m
     * @param $r
     */
    public function __construct($p, $u, $m, &$r)
    {
        $this->p = $p;
        $this->u = $u;
        $this->m = $m;
        $this->r = &$r;
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
            $project = $this->p;
            $meta = $this->m;
            // $member = DB::table('proj_members')->where('member_id', $user->id)->where('project_id', $project->id)->first();
            // if ($member === null) {
            $member = DB::table('proj_members')->insertOrIgnore(['member_id' => $user->id, 'project_id' => $project->id, 'member_type' => $meta['member_type'], 'role' => $meta['role']]);
            // }
            return $member;
        } catch (\Exception $e) {
            $this->r = env('APP_ENV') !== 'production' ? ['error' => $e->getMessage(), 'trace' => $e->getTrace()] : ['error' => 'An error has occurred'];
            return false;
        }
    }
}
