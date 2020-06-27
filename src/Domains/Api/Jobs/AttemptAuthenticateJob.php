<?php

namespace App\Domains\Api\Jobs;

use Illuminate\Support\Facades\Auth;
use Lucid\Foundation\Job;

class AttemptAuthenticateJob extends Job
{
    private $email, $token;

    /**
     * Create a new job instance.
     *
     * @param string $email
     * @param string $token
     */
    public function __construct($email, $token)
    {
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return array
     */
    public function handle()
    {
        //$tokenResult = null;
        if (Auth::check() === true) {
            $user = Auth::user();
            //$user->tokens()->delete();
            $tokenResult = $user->tokens();
            return ['body' => ['success' => true, 'message' => 'ok', 'access_token' => $tokenResult], 'code' => 200];
        }
        if (Auth::guard('web')->attempt(['email' => $this->email, 'password' => $this->token])) {
            $user = Auth::user();
            $tokenResult = $user->createToken('accessToken')->plainTextToken;
            return ['body' => ['success' => true, 'message' => 'ok', 'access_token' => $tokenResult], 'code' => 200];
        } else {
            return ['body' => ['success' => false, 'message' => 'User not found'], 'code' => 404];
        }
    }
}
