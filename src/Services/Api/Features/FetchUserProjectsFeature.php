<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\FetchProjectsJob;
use App\Domains\Api\Jobs\GetUserJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Illuminate\Support\Facades\Auth;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class FetchUserProjectsFeature extends Feature
{
    public function handle(Request $request)
    {
        $owner = Auth::user();
        $p = $this->run(new FetchProjectsJob($owner, $owner->id, $ret));
        return $p === false ? $this->run(new RespondWithJsonErrorJob($ret, 403, 403)) : $this->run(new RespondWithJsonJob($p));
    }
}
