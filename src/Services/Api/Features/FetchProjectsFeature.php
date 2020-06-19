<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\FetchProjectsJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Illuminate\Support\Facades\Auth;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class FetchProjectsFeature extends Feature
{
    public function handle(Request $request)
    {
        $user = Auth::user();
        $p = $this->run(new FetchProjectsJob($user->display_name, $user->social_id, $ret));
        return $p === false ? $this->run(new RespondWithJsonErrorJob($ret, 403)) : $this->run(new RespondWithJsonJob($p));
    }
}
