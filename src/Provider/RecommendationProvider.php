<?php

declare(strict_types=1);

namespace App\Provider;

use App\Provider\Interface\RecommendationProviderInterface;
use App\RecommendationAlgorithm\Interface\RecommendationAlgorithmInterface;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Traversable;

use function sprintf;

class RecommendationProvider implements RecommendationProviderInterface
{
    public function __construct(
        #[TaggedIterator('recommendation.algorithm')] protected readonly Traversable $recommendationAlgorithms,
        protected readonly MovieTitleProvider $movieTitleProvider,
    ) {
    }

    public function provide(string $recommendationType, int $numberOfRecommendations = 3): array
    {
        /** @var RecommendationAlgorithmInterface $algorithm */
        foreach ($this->recommendationAlgorithms as $algorithm) {
            if (true === $algorithm->supports($recommendationType)) {
                return $algorithm->getRecommendations($numberOfRecommendations, $this->movieTitleProvider->provide());
            }
        }

        throw new RuntimeException(
            sprintf('No algorithm found to support recommendation type: %s', $recommendationType),
            500,
        );
    }
}
