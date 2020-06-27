<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\CreateCommentJob;
use App\Domains\Api\Jobs\CreateIssueJob;
use App\Domains\Api\Jobs\CreateIssueThreadJob;
use App\Domains\Api\Jobs\GetProjectJob;
use App\Domains\Api\Jobs\NewThreadActivityJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Illuminate\Support\Facades\Auth;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class MakeIssueFeature extends Feature
{
    public function handle(Request $request)
    {
        if (Auth::check() === false) return $this->run(new RespondWithJsonErrorJob('Not logged in', 403, 403));
        $issue = $request->issue;
        $proj = $request->projectName;
        $author = Auth::user();
        $proj = $this->run(new GetProjectJob($author, $proj, $ret));
        if ($proj === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        $iss = $this->run(new CreateIssueJob($issue, $author->id, $proj->id, $ret));
        if ($iss === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        $thd = $this->run(new CreateIssueThreadJob($iss, $ret));
        if ($thd === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        $payload = ['body' => $issue['body']];
        $cmt = $this->run(new CreateCommentJob($iss, $thd, $payload, $ret));
        if ($cmt === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        $thd->comments = [$cmt];
        $activity = $this->run(new NewThreadActivityJob($thd, $author, 'opened', $thd->id, [], $ret));
        if ($activity === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        return $this->run(new RespondWithJsonJob(['thread' => $thd, 'issue' => $iss, 'project' => $proj], 201));
    }
}
