<?php

namespace App\Domains\Api\Jobs;

use Illuminate\Support\Facades\Storage;
use Lucid\Foundation\Job;
use Illuminate\Http\UploadedFile;

class UploadFilesJob extends Job
{
    private $files;

    /**
     * Create a new job instance.
     *
     * @param $files
     */
    public function __construct($files)
    {
        $this->files = $files;
    }

    /**
     * Execute the job.
     *
     * @return string
     */
    public function handle()
    {
        //var_dump($this->files);
        $path = '';
        foreach ($this->files as $file) {
            $path = $file->store('uploads');
        }
        return $path;
    }
}
