<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\AddProjectMemberJob;
use App\Domains\Api\Jobs\CreateUserProjectJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Illuminate\Support\Facades\Auth;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class InviteUserToProjectFeature extends Feature
{
    public function handle(Request $request)
    {
        if (Auth::check() === false) return $this->run(new RespondWithJsonErrorJob('Not logged in', 401));
        $project = $request->project;
        $role = $request->role;
        $user = $request->user; // email or username
        $ok = $this->run(new CreateUserProjectJob((array) $project, $user,$ret));
        $meta = ['member_type' => 'member', 'role' => $role];
        if ($ok === false) return $this->run(new RespondWithJsonErrorJob($ret, 403, 403));
        $ok = $this->run(new AddProjectMemberJob($project, $user, $meta, $ret));
        return $ok === false ? $this->run(new RespondWithJsonErrorJob($ret, 403, 403)) : $this->run(new RespondWithJsonJob($ok, 201));
    }
}
