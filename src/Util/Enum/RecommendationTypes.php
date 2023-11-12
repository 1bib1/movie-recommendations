<?php

declare(strict_types=1);

namespace Enum;

final class RecommendationTypes: string
{
    public const RANDOM = 'RANDOM';
    public const TITLE_STARTS_WITH_W = 'TITLE_STARTS_WITH_W';
    public const MULTIPLE_WORDS_IN_TITLE = 'MULTIPLE_WORDS_IN_TITLE';

    public static function getValues(): array
    {
        return [
            self::RANDOM,
            self::TITLE_STARTS_WITH_W,
            self::MULTIPLE_WORDS_IN_TITLE,
        ];
    }
}
