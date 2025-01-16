<?php

namespace App\Contracts;

interface ArticleReaderInterface
{
    public function articleGet(): void;

    public function formatter(mixed $payload): array;
}
