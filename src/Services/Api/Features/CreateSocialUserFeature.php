<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\CreateSocialUserJob;
use Framework\User;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class CreateSocialUserFeature extends Feature
{
    public function handle($soc)
    {
        return $this->run(new CreateSocialUserJob($soc));
    }
}
