<?php

namespace App\Domains\Api\Jobs;

use Framework\Issue;
use Framework\Project;
use Framework\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Lucid\Foundation\Job;

class CreateIssueJob extends Job
{
    private $m_issue, $m_user, $m_project, $m_return;

    /**
     * Create a new job instance.
     *
     * @param array $i
     * @param int $u
     * @param int $p
     * @param $r
     */
    public function __construct($i, $u, $p, &$r)
    {
        $this->m_issue = $i;
        $this->m_user = $u;
        $this->m_project = $p;
        $this->m_return = &$r;
    }

    /**
     * Execute the job.
     *
     * @return bool|Issue
     */
    public function handle()
    {
        $project = $this->m_project;
        $user = $this->m_user;
        try {
            $assignees = [];
            foreach ($this->m_issue['assignees'] as $assignee) {
                array_push($assignees, User::firstWhere('social_id', $assignee['value'])->id);
            }
            $issue = Issue::firstOrCreate([
                'project_id' => $project,
                'author_id' => $user,
                'title' => $this->m_issue['title'],
                'description' => $this->m_issue['body'],
                'status' => 'open',
                'meta' => json_encode([
                    'labels' => $this->m_issue['labels'],
                    'assignees' => $assignees,
                    'participants' => [$user]
                ])
            ]);
            $issue->meta = json_decode($issue->meta);
            $issue->project;
            $issue->thread;
            $issue->author;
            return $issue;
        } catch (\Exception $e) {
            $this->m_return = env('APP_ENV') !== 'production' ? ['error' => $e->getMessage(), 'trace' => $e->getTrace()] : ['error' => 'An error has occurred'];
            return false;
        }
    }
}
