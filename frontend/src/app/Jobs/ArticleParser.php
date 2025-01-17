<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ArticleParser implements ShouldQueue
{
    use Queueable;

    public function __construct(public array $article)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        echo "Hello from frontend".PHP_EOL;
    }
}
