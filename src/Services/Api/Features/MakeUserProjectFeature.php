<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\AddProjectMemberJob;
use App\Domains\Api\Jobs\CreateUserProjectJob;
use App\Domains\Api\Jobs\NewThreadActivityJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Illuminate\Support\Facades\Auth;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class MakeUserProjectFeature extends Feature
{
    public function handle(Request $request)
    {
        if (Auth::check() === false) return $this->run(new RespondWithJsonErrorJob('Not logged in', 401));
        $project = $request->project;
        $user = Auth::user();
        $project = $this->run(new CreateUserProjectJob((array) $project, $user,$ret));
        if ($project === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        $meta = ['member_type' => 'owner', 'role' => 'owner'];
        $ok = $this->run(new AddProjectMemberJob($project, $user, $meta, $ret));
        $proj = ['m' => 'OK', 's' => 200, 'p' => $project];
        return $ok === false ? $this->run(new RespondWithJsonErrorJob($ret, 403, 403)) : $this->run(new RespondWithJsonJob($proj, 201));
    }
}
