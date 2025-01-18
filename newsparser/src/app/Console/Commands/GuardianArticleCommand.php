<?php

namespace App\Console\Commands;

use App\Jobs\OnNewArticleGenerated;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class GuardianArticleCommand extends ArticleCommand
{
    protected $signature = 'app:guardian-articles';

    protected $description = 'Fetch guardian news articles';

    public function handle()
    {
        $items = $this->getArticles();

        if (isset($items['response']['results'])) {
            foreach ($items['response']['results'] as $payload) {
                $article = [
                    'source' => 'Guardian',
                    'author' => null,
                    'title' => $payload['webTitle'],
                    'category' => $payload['pillarName'],
                    'description' => $payload['sectionName'],
                    'url' => $payload['webUrl'],
                    'image_url' => null,
                    'published_at' => Carbon::parse($payload['webPublicationDate'])->format('Y-m-d H:i:s'),
                ];

                OnNewArticleGenerated::dispatch($article);
            }
        }
    }

    public function getProviderName(): string
    {
        return 'guardianapis';
    }

    public function getQueryParams(): array
    {
        $cachingKey = Carbon::now()->startOfDay()->getTimestamp().'-'.$this->getProviderName();

        $page = Cache::remember($cachingKey, 24*60*60, function () use($cachingKey) {
            return intval(Cache::get($cachingKey)) + 1;
        });

        return [
            'api-key' => config('services.'.$this->getProviderName().'.key'),
            'page' => $page
        ];
    }
}
