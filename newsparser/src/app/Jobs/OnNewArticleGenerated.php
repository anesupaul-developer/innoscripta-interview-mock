<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class OnNewArticleGenerated implements ShouldQueue
{
    use Queueable;

    public mixed $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        echo 'Hello from NewsParser MicroService'.PHP_EOL;
    }
}
