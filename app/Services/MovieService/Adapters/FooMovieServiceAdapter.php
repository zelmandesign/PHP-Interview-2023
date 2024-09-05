<?php

namespace App\Services\MovieService\Adapters;

use External\Foo\Movies\MovieService as FooMovieService;
use External\Foo\Exceptions\ServiceUnavailableException;

class FooMovieServiceAdapter implements MovieServiceAdapterInterface
{
    private FooMovieService $fooMovieService;

    public function __construct(FooMovieService $fooMovieService)
    {
        $this->fooMovieService = $fooMovieService;
    }

    /**
     * @throws ServiceUnavailableException
     */
    public function getTitles(): array
    {
        return $this->fooMovieService->getTitles();
    }
}
