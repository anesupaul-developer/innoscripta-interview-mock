<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArticleParser implements ShouldQueue
{
    public mixed $payload = [];

    public function __construct($data)
    {
        $this->payload = $data;
    }

    public function handle(): void
    {
        $this->payload = $this->data ?? $this->payload;

        $article = Article::create($this->payload);

        echo 'Article '.$article->id.' has been created';
    }
}
