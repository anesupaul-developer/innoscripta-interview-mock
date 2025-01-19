<?php

namespace App\Console\Commands;

use App\Jobs\OnNewArticleGenerated;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class NewYorkTimesArticleCommand extends ArticleCommand
{
    protected $signature = 'app:nyt-articles';

    protected $description = 'Fetch new york times news articles';

    public function handle()
    {
        $items = $this->getArticles();

        if (isset($items['response']['docs'])) {
            foreach ($items['response']['docs'] as $payload) {
                $imgBaseUrl = 'https://static01.nyt.com/';

                $path = collect($payload['multimedia'])->first();

                $imageUrl = isset($path['url']) ? str($imgBaseUrl)->append($path['url'])->toString() : null;
                $article = [
                    'source' => $payload['source'],
                    'author' => $payload['byline']['original'],
                    'title' => $payload['abstract'],
                    'description' => $payload['lead_paragraph'],
                    'category' => $payload['type_of_material'],
                    'url' => $payload['web_url'],
                    'image_url' => $imageUrl,
                    'published_at' => Carbon::parse($payload['pub_date'])->getTimestamp(),
                ];

                OnNewArticleGenerated::dispatch($article);
            }
        }
    }

    public function getProviderName(): string
    {
        return 'newyorktimes';
    }

    public function getQueryParams(): array
    {
        $cachingKey = Carbon::now()->startOfDay()->getTimestamp().'-'.$this->getProviderName();

        $page = Cache::remember($cachingKey, 24 * 60 * 60, function () use ($cachingKey) {
            return intval(Cache::get($cachingKey)) + 1;
        });

        return [
            'api-key' => config('services.'.$this->getProviderName().'.key'),
            'page' => $page,
        ];
    }
}
