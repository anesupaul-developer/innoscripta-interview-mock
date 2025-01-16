<?php

namespace App\Services;

use App\Contracts\ArticleReaderInterface;

class NewsApiOrgService implements ArticleReaderInterface
{

    public function articleGet(): void
    {

    }

    public function formatter(mixed $payload): array
    {
        return $payload;
    }
}
