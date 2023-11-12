<?php

declare(strict_types=1);

namespace App\Tests\Provider;

use App\Provider\MovieTitleProvider;
use App\Provider\RecommendationProvider;
use App\Tests\Util\RecommendationAlgorithmMock;
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

    public function testAlgorithm(): void
    {
        $this->recommendationProvider = new RecommendationProvider([new RecommendationAlgorithmMock()], $this->titleProvider);
        $result = $this->recommendationProvider->provide(RecommendationAlgorithmMock::SUPPORTED_TYPE);

        self::assertEqualsCanonicalizing(RecommendationAlgorithmMock::RETURNED_ARRAY, $result);
    }
}
