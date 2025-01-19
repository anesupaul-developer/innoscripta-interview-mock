<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class OnNewArticleGenerated implements ShouldQueue
{
    public mixed $payload = [];

    public function __construct($data)
    {
        $this->payload = $data;
    }

    public function handle(): void
    {
        $this->payload = $this->data ?? $this->payload;

        $exists = DB::table('articles')
            ->where('source', $this->payload['source'])
            ->where('title', $this->payload['title'])
            ->where('published_at', $this->payload['published_at'])
            ->exists();

        if (! $exists) {
            $article = Article::create($this->payload);

            echo 'Article '.$article->id.' has been created'.PHP_EOL;
        }
    }
}
