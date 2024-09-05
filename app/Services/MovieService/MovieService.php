<?php

namespace App\Services\MovieService;

use App\Services\MovieService\Adapters\BarMovieServiceAdapter;
use App\Services\MovieService\Adapters\BazMovieServiceAdapter;
use App\Services\MovieService\Adapters\FooMovieServiceAdapter;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MovieService
{
    private const CACHE_DURATION = 3600;
    private BarMovieServiceAdapter $barMovieServiceAdapter;
    private BazMovieServiceAdapter $bazMovieServiceAdapter;
    private FooMovieServiceAdapter $fooMovieServiceAdapter;

    public function __construct(
        BarMovieServiceAdapter $barMovieServiceAdapter,
        BazMovieServiceAdapter $bazMovieServiceAdapter,
        FooMovieServiceAdapter $fooMovieServiceAdapter
    ) {
        $this->barMovieServiceAdapter = $barMovieServiceAdapter;
        $this->bazMovieServiceAdapter = $bazMovieServiceAdapter;
        $this->fooMovieServiceAdapter = $fooMovieServiceAdapter;
    }

    public function getAllTitles(): array
    {
        $barTitles = $this->getTitlesWithCacheFallback($this->barMovieServiceAdapter, 'bar_movie_titles');
        $bazTitles = $this->getTitlesWithCacheFallback($this->bazMovieServiceAdapter, 'baz_movie_titles');
        $fooTitles = $this->getTitlesWithCacheFallback($this->fooMovieServiceAdapter, 'foo_movie_titles');

        return array_merge($barTitles, $bazTitles, $fooTitles);
    }

    private function getTitlesWithCacheFallback($service, $cacheKey): array
    {
        try {
            $titles = $this->getTitlesWithRetry($service);

            $this->cacheTitles($cacheKey, $titles);

            return $titles;
        } catch (Exception $e) {
            Log::error("Failed to fetch fresh movie titles for $cacheKey: " . $e->getMessage());

            return $this->getCachedTitles($cacheKey);
        }
    }

    private function getTitlesWithRetry($service, $retryCount = 3): array
    {
        $attempts = 0;

        while ($attempts < $retryCount) {
            try {
                return $service->getTitles();
            } catch (Exception $e) {
                $attempts++;
                Log::error("Attempt $attempts failed for service " . get_class($service) . ": " . $e->getMessage());

                if ($attempts >= $retryCount) {
                    Log::critical("All retry attempts failed for service " . get_class($service) . ": " . $e->getMessage());
                    throw $e;
                }

                sleep(pow(2, $attempts));
            }
        }

        return [];
    }

    public function cacheTitles($cacheKey, array $titles): void
    {
        Cache::put($cacheKey, $titles, self::CACHE_DURATION);
    }

    public function getCachedTitles($cacheKey): mixed
    {
        if (Cache::has($cacheKey)) {
            Log::info("Using cached movie titles for $cacheKey as fallback.");
            return Cache::get($cacheKey);
        }

        Log::warning("No cached data available for $cacheKey.");
        return [];
    }
}
