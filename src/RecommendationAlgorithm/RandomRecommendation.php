<?php

declare(strict_types=1);

namespace App\RecommendationAlgorithm;

use App\RecommendationAlgorithm\Interface\RecommendationAlgorithmInterface;
use App\Util\Const\RecommendationTypes;
use App\Util\Generator\NonRepetitiveRandomNumberGenerator;
use LogicException;

class RandomRecommendation implements RecommendationAlgorithmInterface
{
    public function __construct(
        protected readonly NonRepetitiveRandomNumberGenerator $randomNumberGenerator,
    ) {
    }

    public function supports(string $recommendationType): bool
    {
        return RecommendationTypes::RANDOM === $recommendationType;
    }

    public function getRecommendations(int $numberOfRecommendations, array $availableEntries): array
    {
        // get unique entries and reset keys
        $availableEntries = array_values(array_unique($availableEntries));
        $movieCount = count($availableEntries);

        if ($numberOfRecommendations > $movieCount) {
            throw new LogicException('Number of requested recommendations is lower than number of available entries');
        }

        if ($numberOfRecommendations === $movieCount) {
            return $availableEntries;
        }


        return $this->getRandomRecommendations($numberOfRecommendations, $availableEntries);
    }

    protected function getRandomRecommendations(int $numberOfRecommendations, array $movies): array
    {
        $randomNumbers = $this->randomNumberGenerator->generate(0, count($movies) - 1, $numberOfRecommendations);

        $data = [];


        foreach ($randomNumbers as $randomNumber) {
            $data[] = $movies[$randomNumber];
        }

        return $data;
    }
}
