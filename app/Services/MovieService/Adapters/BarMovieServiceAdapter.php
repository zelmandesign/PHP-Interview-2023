<?php

namespace App\Services\MovieService\Adapters;

use External\Bar\Movies\MovieService as BarMovieService;
use External\Bar\Exceptions\ServiceUnavailableException;

class BarMovieServiceAdapter implements MovieServiceAdapterInterface
{
    private BarMovieService $barMovieService;

    public function __construct(BarMovieService $barMovieService)
    {
        $this->barMovieService = $barMovieService;
    }

    /**
     * @throws ServiceUnavailableException
     */
    public function getTitles(): array
    {
        $titles = $this->barMovieService->getTitles();

        if (isset($titles['titles']) && is_array($titles['titles'])) {
            return array_column($titles['titles'], 'title');
        }

        return [];
    }
}
