<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\CreateCommentJob;
use App\Domains\Api\Jobs\CreateIssueThreadJob;
use App\Domains\Api\Jobs\GetIssueJob;
use App\Domains\Api\Jobs\GetThreadJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class AddCommentFeature extends Feature
{
    public function handle(Request $request)
    {
        $owner = $request->owner;
        $project = $request->projectName;
        $issueId = $request->issueId;
        $payload = $request->payload;
        $issue = $this->run(new GetIssueJob($owner, $project, $issueId, $ret));
        $thread = $issue['t'];
        if ($issue === false) return $this->run(new RespondWithJsonErrorJob($ret, 403));
        //var_dump($thread);
        //if ($thread === false) return $this->run(new RespondWithJsonErrorJob($ret, 403));
        $cmt = $this->run(new CreateCommentJob($issue, $thread, (array) $payload, $ret));
        $thread = $this->run(new GetThreadJob($thread->id));
        if ($cmt === false) return $this->run(new RespondWithJsonErrorJob($ret, 403));
        return $this->run(new RespondWithJsonJob(['thread' => $thread, 'issue' => $issue, 'comment' => $cmt], 201));
    }
}
