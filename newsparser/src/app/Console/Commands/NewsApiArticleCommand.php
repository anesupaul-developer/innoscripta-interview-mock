<?php

namespace App\Console\Commands;

use App\Jobs\OnNewArticleGenerated;
use Carbon\Carbon;

class NewsApiArticleCommand extends ArticleCommand
{
    protected $signature = 'app:news-org-articles';

    protected $description = 'Get News Articles from News API Org';

    public function handle()
    {
        $items = $this->getArticles();

        if (isset($items['articles'])) {
            foreach ($items['articles'] as $payload) {
                $article = [
                    'source' => $payload['source']['name'],
                    'author' => $payload['author'],
                    'title' => $payload['title'],
                    'description' => $payload['description'],
                    'url' => $payload['url'],
                    'image_url' => $payload['urlToImage'],
                    'published_at' => Carbon::parse($payload['publishedAt'])->getTimestamp(),
                ];

                OnNewArticleGenerated::dispatch($article);
            }
        }
    }

    public function getProviderName(): string
    {
        return 'newsapiorg';
    }

    public function getQueryParams(): array
    {
        return [
            'page' => 1,
            'apiKey' => config('services.'.$this->getProviderName().'.key'),
            'q' => '',
            'sources' => '',
            'language' => '',
            'country' => 'us',
        ];
    }
}
