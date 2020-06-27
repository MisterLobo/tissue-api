<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\GetIssueJob;
use App\Domains\Api\Jobs\GetProjectJob;
use App\Domains\Api\Jobs\GetThreadJob;
use App\Domains\Api\Jobs\GetUserJob;
use App\Domains\Api\Jobs\GetUserVotesJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Illuminate\Support\Facades\Auth;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class GetIssueFeature extends Feature
{
    public function handle(Request $request)
    {
        $owner = $request->owner;
        $project = $request->projectName;
        $issueId = $request->issueId;
        $owner = $this->run(new GetUserJob($owner, $ret));
        if ($owner === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        $project = $this->run(new GetProjectJob($owner, $project, $ret));
        if ($project === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        $issue = $this->run(new GetIssueJob($owner, $project, $issueId, $ret));
        if ($issue === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, $issue['status'] ?? 403));
        $thread = $this->run(new GetThreadJob($issue, $project, $owner, $ret));
        if ($thread === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        $u = Auth::user();
        $user = $this->run(new GetUserVotesJob($u, $ret));
        return $issue === false ? $this->run(new RespondWithJsonErrorJob($ret, 403, 403)) : $this->run(new RespondWithJsonJob(['i' => $issue, 'p' => $project, 't' => $thread, 'u' => $user]));
        //return $issue === false ? $this->run(new RespondWithJsonErrorJob($ret, 403, $issue['status'] ?? 403)) : $this->run(new RespondWithJsonJob(['i' => $issue, 'p' => $project, 'u' => $user]));
    }
}
