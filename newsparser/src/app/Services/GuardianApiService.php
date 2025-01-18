<?php

namespace App\Services;

use App\Contracts\ArticleReaderInterface;
use App\Jobs\ArticleParser;
use App\Models\Article;
use Carbon\Carbon;

class GuardianApiService implements ArticleReaderInterface
{

    public function send(mixed $article): void
    {
        ArticleParser::dispatch($this->formatter($article));
    }

    public function formatter(mixed $payload): array
    {
        return [
            'source' => "Guardian",
            'author' => null,
            'title' => $payload['webTitle'],
            'description' => $payload['sectionName'],
            'url' => $payload['webUrl'],
            'image_url' => null,
            'published_at' => Carbon::parse($payload['webPublicationDate'])->format('Y-m-d H:i:s')
        ];
    }
}
