<?php

namespace App\Console\Commands;

use App\Services\GuardianApiService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class RetrieveGuardianArticles extends Command
{
    protected $signature = 'app:guardian-articles';

    protected $description = 'Fetch guardian news articles';

    public function __construct(public GuardianApiService $apiOrgService)
    {
        parent::__construct();
    }

    public function handle()
    {
        $data = [
            'page' => 1,
            'api-key' => config('services.guardianapis.key')
        ];

        $url = Str::of(config('services.guardianapis.url'))->append('?')->append(http_build_query($data));

        $response = Http::get($url);

        if ($response->successful()) {
            $articles = $response->json()['response']['results'];

            foreach ($articles as $article) {
                $this->apiOrgService->send($article);
            }
        }
    }
}
