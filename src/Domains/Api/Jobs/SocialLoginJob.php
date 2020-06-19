<?php

namespace App\Domains\Api\Jobs;

use Laravel\Socialite\Facades\Socialite;
use Lucid\Foundation\Job;

class SocialLoginJob extends Job
{
    private $provider;
    /**
     * Create a new job instance.
     *
     * @param string $provider
     */
    public function __construct($provider)
    {
        $this->provider = $provider;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        return Socialite::driver($this->provider)->stateless()->user();
    }
}
