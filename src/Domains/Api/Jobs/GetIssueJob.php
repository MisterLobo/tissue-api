<?php

namespace App\Domains\Api\Jobs;

use Carbon\Traits\Converter;
use Framework\Issue;
use Framework\IssueThread;
use Framework\Project;
use Framework\User;
use Framework\Vote;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Lucid\Foundation\Job;

class GetIssueJob extends Job
{
    private $o, $p, $i, $ret;

    /**
     * Create a new job instance.
     *
     * @param string $o
     * @param string $p
     * @param int $i
     * @param mixed $ret
     */
    public function __construct($o, $p, $i, &$ret)
    {
        $this->o = $o;
        $this->p = $p;
        $this->i = $i;
        $this->ret = &$ret;
    }

    /**
     * Execute the job.
     *
     * @return array|bool
     */
    public function handle()
    {
        try {
            $owner = User::firstWhere('display_name', $this->o);
            //file_put_contents('owner.json', json_encode($owner, JSON_PRETTY_PRINT));
            //die(json_encode($owner));
            //print_r($owner);
            //dd($owner);
            //var_dump($this->p);
            $project = Project::where('owner_id', $owner->social_id)->where('slug', $this->p)->firstOrFail();
            //$project = DB::table('projects')->where('owner_id', $owner->social_id)->where('slug', $this->p)->first();
            //file_put_contents('project.json', json_encode($project, JSON_PRETTY_PRINT));
            //var_dump($project);
            //$project = Project::find($proj->id);
            //die(json_encode($project));
            $issue = Issue::findOrFail($this->i);
            //file_put_contents('issue.json', json_encode($issue, JSON_PRETTY_PRINT));
            //print_r($issue);
            $thread = IssueThread::where('issue_id', $issue->id)->where('project_id', $project->id)->firstOrFail();
            //file_put_contents('thread.json', json_encode($thread, JSON_PRETTY_PRINT));
            //print_r($thread);
            //dd($issue);
            //dd($thread);
            $meta = $issue->meta !== null ? json_decode($issue->meta) : [];
            $issue->meta = $meta;
            $issue->labels = $meta->labels !== null ? $meta->labels : [];
            //var_dump($meta);
            $a = $meta->assignees;
            $assignees = [];
            foreach ($a as $assignee) {
                array_push($assignees, $assignee->value);
            }
            $assignees = $meta->assignees !== null ? User::select('users.*')->whereIn('social_id', $assignees)->get()->toArray() : [];
            $issue->assignees = $assignees;
            $parts = $meta->participants !== null ? User::select('users.*')->whereIn('social_id', $meta->participants)->get()->toArray() : [];
            $issue->participants = $parts;
            $issue->author;
            $issue->project;
            $issue->project->owner;
            $issue->thread = $thread;
            $thread->author;
            foreach ($thread->comments as $comment) {
                $comment->author;
                $comment->votes;
                $comment->upvotes = Vote::where(['comment_id' => $comment->id, 'vote' => 'up'])->count();
                $comment->downvotes = Vote::where(['comment_id' => $comment->id, 'vote' => 'down'])->count();
            }
            return ['i' => $issue, 't' => $thread, 'o' => $issue->author, 'p' => $issue->project];
        } catch (ModelNotFoundException $e) {
            $this->ret = ['error' => 'Issue not found', 'message' => $e->getMessage(), 'status' => 403];
            return false;
        } catch (\Exception $e) {
            $this->ret = ['error' => 'Error in issue', 'message' => $e->getMessage(), 'status' => 403];
            return false;
        }
    }
}
