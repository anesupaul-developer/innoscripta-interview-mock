<?php

namespace App\Contracts;

interface ArticleReaderInterface
{
    public function send(mixed $article): void;

    public function formatter(mixed $payload): array;
}
