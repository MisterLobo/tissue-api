<?php

namespace App\Domains\Api\Jobs;

use Framework\Issue;
use Lucid\Foundation\Job;

class CreateIssueJob extends Job
{
    private $m_issue, $m_return;

    /**
     * Create a new job instance.
     *
     * @param array $i
     * @param $r
     */
    public function __construct($i, &$r)
    {
        $this->m_issue = $i;
        $this->m_return = &$r;
    }

    /**
     * Execute the job.
     *
     * @return bool|Issue
     */
    public function handle()
    {
        try {
            $issue = Issue::firstOrCreate([
                'project_id' => $this->m_issue['project_id'],
                'author_id' => $this->m_issue['author_id'],
                'title' => $this->m_issue['title'],
                'description' => $this->m_issue['body'],
                'status' => 'open',
                'meta' => json_encode([
                    'labels' => $this->m_issue['labels'],
                    'assignees' => $this->m_issue['assignees'],
                    'participants' => $this->m_issue['participants']
                ])
            ]);
            $issue->project;
            $issue->thread;
            $issue->author;
            return $issue;
        } catch (\Exception $e) {
            if (env('APP_ENV') !== 'development' && env('APP_ENV') !== 'local') $this->m_return = ['error' => $e->getMessage()];
            else  $this->m_return = ['error' => $e->getMessage(), 'trace' => $e];
            return false;
        }
    }
}
