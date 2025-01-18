<?php

namespace App\Console\Commands;

use App\Services\GuardianApiService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class RetrieveNewYorkTimesArticles extends Command
{
    protected $signature = 'app:nyt-articles';

    protected $description = 'Fetch new york times news articles';

    public function __construct(public GuardianApiService $apiOrgService)
    {
        parent::__construct();
    }

    public function handle()
    {
        $data = [
            'page' => 1,
            'api-key' => config('services.newyorktimes.key')
        ];

        $url = Str::of(config('services.newyorktimes.url'))->append('?')->append(http_build_query($data));

        $response = Http::get($url);

        if ($response->successful()) {
            $articles = $response->json()['response']['results'];

            foreach ($articles as $article) {
                $this->apiOrgService->send($article);
            }
        }
    }
}
