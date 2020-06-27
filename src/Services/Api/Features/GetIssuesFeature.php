<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\GetIssuesJob;
use App\Domains\Api\Jobs\GetProjectJob;
use App\Domains\Api\Jobs\GetUserJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class GetIssuesFeature extends Feature
{
    public function handle(Request $request)
    {
        $owner = $request->owner;
        $project = $request->projectName;
        $owner = $this->run(new GetUserJob($owner, $ret));
        if ($owner === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        $project = $this->run(new GetProjectJob($owner, $project, $ret));
        if ($project === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        $list = $this->run(new GetIssuesJob($owner, $project, $ret));
        if ($list === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        return $this->run(new RespondWithJsonJob(['owner' => $owner, 'project' => $project, 'list' => $list]));
    }
}
