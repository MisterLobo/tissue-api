<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\AddOrUpdateVoteJob;
//use App\Domains\Api\Jobs\CreateVoteJob;
use App\Domains\Api\Jobs\GetCommentByIdJob;
use App\Domains\Api\Jobs\GetCommentVotesJob;
use App\Domains\Api\Jobs\GetProjectJob;
use App\Domains\Api\Jobs\GetUserJob;
use App\Domains\Api\Jobs\GetUserVotesJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Illuminate\Support\Facades\Auth;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class MakeVoteFeature extends Feature
{
    public function handle(Request $request)
    {
        $ownerName = $request->owner;
        $slug = $request->projectName;
        $commentId = $request->commentId;
        $vote = $request->payload['body'];
        $owner = $this->run(new GetUserJob($ownerName, $ret));
        if ($owner === false) return $this->run(new RespondWithJsonErrorJob($ret));
        $project = $this->run(new GetProjectJob($owner, $slug, $ret));
        if ($project === false) return $this->run(new RespondWithJsonErrorJob($ret));
        $comment = $this->run(new GetCommentByIdJob($commentId, $ret));
        if ($comment === false) return $this->run(new RespondWithJsonErrorJob($ret));
        $voter = Auth::user();
        $vote = $this->run(new AddOrUpdateVoteJob($voter->id, $commentId, $vote, $ret));
        $comment = $this->run(new GetCommentVotesJob($comment, $ret));
        if ($comment === false) return $this->run(new RespondWithJsonErrorJob($ret));
        $voter = $this->run(new GetUserVotesJob($voter, $ret));
        if ($voter === false) return $this->run(new RespondWithJsonErrorJob($ret));
        return $vote !== false ? $this->run(new RespondWithJsonJob(['vote' => $vote, 'voter' => $voter, 'comment' => $comment], 201)) : $this->run(new RespondWithJsonErrorJob($ret));
    }
}
