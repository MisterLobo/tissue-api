<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\CreateProjectJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class MakeProjectFeature extends Feature
{
    public function handle(Request $request)
    {
        $project = $request->project;
        $ok = $this->run(new CreateProjectJob((array) $project,$ret));
        return $ok === false ? $this->run(new RespondWithJsonErrorJob($ret, 403)) : $this->run(new RespondWithJsonJob($ok, 201));
    }
}
