<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\AttemptAuthenticateJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class UserAuthFeature extends Feature
{
    public function handle(Request $request)
    {
        $request->validate([
            'email' => 'required_without:name|email',
            //'name' => 'required_without:email|min:2',
            'user_token' => 'required'
        ]);
        $email = $request->email;
        $token = $request->user_token;
        $r = $this->run(new AttemptAuthenticateJob($email, $token));
        return $this->run(new RespondWithJsonJob($r['body'], $r['code']));
    }
}
