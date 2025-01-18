<?php

namespace App\Console\Commands;

use App\Jobs\OnNewArticleGenerated;
use Carbon\Carbon;

class RetrieveApiOrgArticles extends HttpArticle
{
    protected $signature = 'app:news-org-articles';

    protected $description = 'Get News Articles from News API Org';

    public function handle()
    {
        $items = $this->getArticles();

        foreach ($items as $payload) {
            $article = [
                'source' => $payload['source']['name'],
                'author' => $payload['author'],
                'title' => $payload['title'],
                'description' => $payload['description'],
                'url' => $payload['url'],
                'image_url' => $payload['urlToImage'],
                'published_at' => Carbon::parse($payload['publishedAt'])->format('Y-m-d H:i:s'),
            ];

            OnNewArticleGenerated::dispatch($article);
        }
    }

    public function getProviderName(): string
    {
        return 'newsapiorg';
    }
}
