<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Psr\SimpleCache\InvalidArgumentException;

abstract class ArticleCommand extends Command
{
    protected function getArticles()
    {
        $settings = config('services.'.$this->getProviderName());

        $url = Str::of($settings['url'])->append('?')->append(http_build_query($this->getQueryParams()));

        $response = Http::get($url);

        if (isset($this->getQueryParams()['page'])) {
            $cachingKey = Carbon::now()->startOfDay()->getTimestamp().'-'.$this->getProviderName();

            Cache::increment($cachingKey);
        }

        if ($response->successful()) {
            return $response->json();
        }

        $this->resetCacheKey();

        return [];
    }

    private function resetCacheKey()
    {
        $cachingKey = Carbon::now()->startOfDay()->getTimestamp().'-'.$this->getProviderName();

        Cache::forget($cachingKey);
    }

    abstract public function getProviderName(): string;

    abstract public function getQueryParams(): array;
}
