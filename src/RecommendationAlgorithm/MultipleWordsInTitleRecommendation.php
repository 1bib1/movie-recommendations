<?php

declare(strict_types=1);

namespace App\RecommendationAlgorithm;

use App\Util\Const\RecommendationTypes;

class MultipleWordsInTitleRecommendation extends RandomRecommendation
{
    private CONST REGEX = '/^[a-zA-Z]+(?:\W[a-zA-Z]+)+$/m';

    public function supports(string $recommendationType): bool
    {
        return RecommendationTypes::MULTIPLE_WORDS_IN_TITLE === $recommendationType;
    }

    public function getRecommendations(int $numberOfRecommendations, array $availableEntries): array
    {
        $preparedArray = preg_filter(self::REGEX, '$0', $availableEntries);

        return parent::getRecommendations($numberOfRecommendations, $preparedArray);
    }
}
