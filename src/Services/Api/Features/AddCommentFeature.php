<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\CreateCommentJob;
use App\Domains\Api\Jobs\CreateIssueThreadJob;
use App\Domains\Api\Jobs\GetIssueJob;
use App\Domains\Api\Jobs\GetProjectJob;
use App\Domains\Api\Jobs\GetThreadJob;
use App\Domains\Api\Jobs\GetUserJob;
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
        $owner = $this->run(new GetUserJob($owner, $ret));
        if ($owner === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        $project = $this->run(new GetProjectJob($owner, $project, $ret));
        if ($project === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        $issue = $this->run(new GetIssueJob($owner, $project, $issueId, $ret));
        if ($issue === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        $thread = $issue->thread;
        if ($thread === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        $cmt = $this->run(new CreateCommentJob($issue, $thread, (array) $payload, $ret));
        if ($cmt === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        $thread = $this->run(new GetThreadJob($issue, $project, $owner, $ret));
        if ($thread === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        return $this->run(new RespondWithJsonJob(['thread' => $thread, 'issue' => $issue, 'comment' => $cmt], 201));
    }
}
