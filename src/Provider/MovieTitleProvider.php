<?php

declare(strict_types=1);

namespace App\Provider;

use App\Util\Const\Movies;

final class MovieTitleProvider
{
    public function provide(): array
    {
        return Movies::MOVIES;
    }
}
