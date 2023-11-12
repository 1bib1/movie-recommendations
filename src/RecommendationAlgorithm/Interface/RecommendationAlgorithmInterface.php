<?php

declare(strict_types=1);

namespace App\RecommendationAlgorithm\Interface;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('recommendation.algorithm')]
interface RecommendationAlgorithmInterface
{
    public function supports(string $recommendationType): bool;
    public function getRecommendations(int $numberOfRecommendations, array $availableEntries): array;
}
