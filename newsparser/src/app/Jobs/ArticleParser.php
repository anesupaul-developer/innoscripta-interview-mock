<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ArticleParser implements ShouldQueue
{
    use Queueable;

    public function __construct($data)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        echo "Hello from NewsParser";
    }
}
