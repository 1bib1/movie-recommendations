<?php

declare(strict_types=1);

namespace App\Tests\Util;

use App\RecommendationAlgorithm\Interface\RecommendationAlgorithmInterface;

final class RecommendationAlgorithmMock implements RecommendationAlgorithmInterface
{
    public const SUPPORTED_TYPE = 'mock';

    public const RETURNED_ARRAY = ['Shrek', 'Mononoke Princess'];

    public function supports(string $recommendationType): bool
    {
        return self::SUPPORTED_TYPE === $recommendationType;
    }

    public function getRecommendations(int $numberOfRecommendations, array $availableEntries): array
    {
        return self::RETURNED_ARRAY;
    }
}
