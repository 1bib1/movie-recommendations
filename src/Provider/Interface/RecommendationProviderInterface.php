<?php

declare(strict_types=1);

namespace App\Provider\Interface;

interface RecommendationProviderInterface
{
    public function provide(string $recommendationType, int $numberOfRecommendations = 3): array;
}
