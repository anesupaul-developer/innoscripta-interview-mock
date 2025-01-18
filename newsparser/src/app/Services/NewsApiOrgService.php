<?php

namespace App\Services;

use App\Contracts\ArticleReaderInterface;
use App\Jobs\ArticleParser;
use Carbon\Carbon;

class NewsApiOrgService implements ArticleReaderInterface
{

    public function send(mixed $article): void
    {
        $payload = $this->formatter($article);

        echo "Processing".PHP_EOL;

        dispatch(new ArticleParser($payload));
    }

    public function formatter(mixed $payload): array
    {
        return [
            'source' => $payload['source']['name'],
            'author' => $payload['author'],
            'title' => $payload['title'],
            'description' => $payload['description'],
            'url' => $payload['url'],
            'image_url' => $payload['urlToImage'],
            'published_at' => Carbon::parse($payload['publishedAt'])->format('Y-m-d H:i:s')
        ];
    }
}
