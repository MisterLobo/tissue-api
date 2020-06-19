<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\GetIssuesJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class GetIssuesFeature extends Feature
{
    public function handle(Request $request)
    {
        $owner = $request->owner;
        $project = $request->projectName;
        $ret = $this->run(new GetIssuesJob($owner, $project));
        return $this->run(new RespondWithJsonJob($ret));
    }
}
