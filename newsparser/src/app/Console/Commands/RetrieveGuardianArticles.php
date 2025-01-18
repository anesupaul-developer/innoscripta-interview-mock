<?php

namespace App\Console\Commands;

use App\Jobs\OnNewArticleGenerated;
use Carbon\Carbon;

class RetrieveGuardianArticles extends HttpArticle
{
    protected $signature = 'app:guardian-articles';

    protected $description = 'Fetch guardian news articles';

    public function handle()
    {
        $items = $this->getArticles();

        foreach ($items as $payload) {
            $article = [
                'source' => 'Guardian',
                'author' => null,
                'title' => $payload['webTitle'],
                'description' => $payload['sectionName'],
                'url' => $payload['webUrl'],
                'image_url' => null,
                'published_at' => Carbon::parse($payload['webPublicationDate'])->format('Y-m-d H:i:s'),
            ];

            OnNewArticleGenerated::dispatch($article);
        }
    }

    public function getProviderName(): string
    {
        return 'guardianapis';
    }
}
