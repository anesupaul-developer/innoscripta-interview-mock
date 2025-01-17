<?php

namespace App\Console\Commands;

use App\Services\NewsApiOrgService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GetNewsApiOrgArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get News Articles from News API Org';

    public function __construct(public NewsApiOrgService $apiOrgService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = [
            'country' => 'us',
            'apiKey' => config('services.newsapiorg.key')
        ];

        $url = Str::of(config('services.newsapiorg.url'))->append('?')->append(http_build_query($data));

        $response = Http::get($url);

        if ($response->successful()) {
            $articles = $response->json()['articles'];

            foreach($articles as $article) {
                $this->apiOrgService->send($article);
            }
        }
    }
}
