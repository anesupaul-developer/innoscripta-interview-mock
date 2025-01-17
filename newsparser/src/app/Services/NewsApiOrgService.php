<?php

namespace App\Services;

use App\Contracts\ArticleReaderInterface;
use App\Jobs\ArticleParser;

class NewsApiOrgService implements ArticleReaderInterface
{

    public function send(mixed $article): void
    {
        ArticleParser::dispatch($this->formatter($article));
    }

    public function formatter(mixed $payload): array
    {
        return $payload;
    }
}
