<?php

namespace App\Domains\Api\Jobs;

use Framework\User;
use Illuminate\Support\Facades\Hash;
use Lucid\Foundation\Job;

class CreateSocialUserJob extends Job
{
    private $user;

    /**
     * Create a new job instance.
     *
     * @param array $u
     */
    public function __construct($u)
    {
        $this->user = $u;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $nick = array_key_exists('nickname', $this->user) ? $this->user['nickname'] : $this->user['name'];
        $dat = ['email' => $this->user['email']];
        $user = User::firstOrNew($dat);
        $user->social_id = $this->user['id'];
        $user->social_provider = $this->user['social_provider'];
        $user->display_name = $nick;
        $user->name = $this->user['name'];
        $user->avatar = $this->user['avatar'];
        $pwd = $this->user['token'];
        $user->password = Hash::make($pwd);
        $user->save();
        $token = $user->createToken('accessToken')->plainTextToken;

        return $token;
    }
}
