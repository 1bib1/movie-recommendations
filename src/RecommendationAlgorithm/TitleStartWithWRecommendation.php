<?php

declare(strict_types=1);

namespace App\RecommendationAlgorithm;

use App\Util\Const\RecommendationTypes;

use function array_filter;
use function mb_strtolower;
use function mb_strlen;

// this normally should be made for any letter...
class TitleStartWithWRecommendation extends RandomRecommendation
{
    public function supports(string $recommendationType): bool
    {
        return RecommendationTypes::TITLE_STARTS_WITH_W === $recommendationType;
    }

    public function getRecommendations(int $numberOfRecommendations, array $availableEntries): array
    {
        $preparedArray = array_filter($availableEntries, function (string $value) {
            return true === str_starts_with(mb_strtolower($value), 'w') && 0 === mb_strlen($value) % 2;
        });

        return parent::getRecommendations($numberOfRecommendations, $preparedArray);
    }
}
