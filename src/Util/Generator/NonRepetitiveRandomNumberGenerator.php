<?php

declare(strict_types=1);

namespace App\Util\Generator;

use function range;
use function shuffle;
use function array_slice;

class NonRepetitiveRandomNumberGenerator
{
    public function generate(int $min, int $max, int $quantity): array
    {
        $numbers = range($min, $max);
        shuffle($numbers);

        return array_slice($numbers, 0, $quantity);
    }
}
