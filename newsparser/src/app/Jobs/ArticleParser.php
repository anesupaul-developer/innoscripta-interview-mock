<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ArticleParser implements ShouldQueue
{
    use Queueable;

    private array $article;

    /**
     * Create a new job instance.
     */
    public function __construct(mixed $data)
    {
        $this->article = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        dd("Event handled successfully");
    }
}
