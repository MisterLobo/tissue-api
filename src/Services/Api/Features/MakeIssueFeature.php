<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\CreateCommentJob;
use App\Domains\Api\Jobs\CreateIssueJob;
use App\Domains\Api\Jobs\CreateIssueThreadJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class MakeIssueFeature extends Feature
{
    public function handle(Request $request)
    {
        $issue = $request->issue;
        //var_dump($issue);
        $iss = $this->run(new CreateIssueJob($issue, $ret));
        if ($iss === false) return $this->run(new RespondWithJsonErrorJob($ret, 403));
        $thd = $this->run(new CreateIssueThreadJob($iss, $ret));
        if ($thd === false) return $this->run(new RespondWithJsonErrorJob($ret, 403));
        $payload = ['body' => $issue['body']];
        $cmt = $this->run(new CreateCommentJob($iss, $thd, $payload, $ret));
        if ($cmt === false) return $this->run(new RespondWithJsonErrorJob($ret, 403));
        $thd->comments = [$cmt];
        return $this->run(new RespondWithJsonJob(['thread' => $thd, 'issue' => $iss], 201));
    }
}
