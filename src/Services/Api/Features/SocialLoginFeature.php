<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\CreateSocialUserJob;
use App\Domains\Api\Jobs\SocialLoginJob;
use App\Domains\Http\Jobs\RespondWithJsonErrorJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class SocialLoginFeature extends Feature
{
    public function handle(Request $request)
    {
        try {
            $provider = $request->provider;
            $u = $this->run(new SocialLoginJob($provider));
            $u->nickname = $u->nickname ?? str_replace(' ', '', $u['name']);
            $u->display_name = $u->nickname;
            //var_dump($u);
            $uu = (array) $u;
            $uu['social_provider'] = $provider;
            $token = $this->run(new CreateSocialUserJob((array) $uu));
            return $this->run(new RespondWithJsonJob(['user' => $u, 'accessToken' => $token]));
        } catch (\Exception $e) {
            return $this->run(new RespondWithJsonErrorJob('Authentication failed. Try again:'.env('APP_ENV') !== 'production' ? $e->getMessage() : '', 403));
        }
    }
}
