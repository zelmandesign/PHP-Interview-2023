<?php

namespace App\Services\MovieService\Adapters;

use External\Baz\Movies\MovieService as BazMovieService;
use External\Baz\Exceptions\ServiceUnavailableException;

class BazMovieServiceAdapter implements MovieServiceAdapterInterface
{
    private BazMovieService $bazMovieService;

    public function __construct(BazMovieService $bazMovieService)
    {
        $this->bazMovieService = $bazMovieService;
    }

    /**
     * @throws ServiceUnavailableException
     */
    public function getTitles(): array
    {
        $titles = $this->bazMovieService->getTitles();
        return $titles['titles'];
    }
}
