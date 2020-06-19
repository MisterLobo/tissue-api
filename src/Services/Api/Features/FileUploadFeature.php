<?php

namespace App\Services\Api\Features;

use App\Domains\Api\Jobs\UploadFilesJob;
use App\Domains\Http\Jobs\RespondWithJsonJob;
use Lucid\Foundation\Feature;
use Illuminate\Http\Request;

class FileUploadFeature extends Feature
{
    public function handle(Request $request)
    {
        $filePath = $this->run(new UploadFilesJob($request->allFiles()));
        return $this->run(new RespondWithJsonJob(env('APP_URL').'/'.$filePath));
    }
}
