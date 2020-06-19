<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\GetIssueJob;
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
        $iss = $this->run(new GetIssueJob($request->owner, $request->projectName, $request->issueId, $ret));
        //var_dump($iss);
        //var_dump($ret);
        $u = Auth::user();
        $user = $this->run(new GetUserVotesJob($u, $ret));
        return $iss === false ? $this->run(new RespondWithJsonErrorJob($ret, 403)) : $this->run(new RespondWithJsonJob(['r' => $iss, 'u' => $user]));
    }
}
