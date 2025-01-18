<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

abstract class HttpArticle extends Command
{
    protected function getArticles()
    {
        $settings = config('services.'.$this->getProviderName());

        $data = [
            'page' => 1,
            'api-key' => $settings['key'],
        ];

        $url = Str::of($settings['url'])->append('?')->append(http_build_query($data));

        $response = Http::get($url);

        if ($response->successful()) {
            return $response->json();
        }

        return [];
    }

    abstract public function getProviderName(): string;
}
