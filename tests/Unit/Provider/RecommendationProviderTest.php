<?php

declare(strict_types=1);

namespace Provider;

use App\Provider\MovieTitleProvider;
use App\Provider\RecommendationProvider;
use Monolog\Test\TestCase;
use RuntimeException;

final class RecommendationProviderTest extends TestCase
{
    private MovieTitleProvider $titleProvider;
    private RecommendationProvider $recommendationProvider;

    protected function setUp(): void
    {
        $this->titleProvider = new MovieTitleProvider();
    }

    public function testExceptionIsThrownWhenNoSupportedAlgorithmIsFound(): void
    {
        self::expectException(RuntimeException::class);

        $this->recommendationProvider = new RecommendationProvider([], $this->titleProvider);
        $this->recommendationProvider->provide('non-existing-algorithm');
    }
}
