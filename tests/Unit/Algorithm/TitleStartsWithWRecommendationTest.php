<?php

declare(strict_types=1);

namespace App\Tests\Algorithm;

use App\RecommendationAlgorithm\TitleStartWithWRecommendation;
use App\Util\Generator\NonRepetitiveRandomNumberGenerator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class TitleStartsWithWRecommendationTest extends TestCase
{
    private MockObject&NonRepetitiveRandomNumberGenerator $randomNumberGenerator;
    private ?TitleStartWithWRecommendation $algorithm;

    protected function setUp(): void
    {
        $this->randomNumberGenerator = $this->createMock(NonRepetitiveRandomNumberGenerator::class);
        $this->algorithm = new TitleStartWithWRecommendation($this->randomNumberGenerator);
    }

    /**
     * @dataProvider getRecommendationsDataProvider
     */
    public function testGetRecommendations(array $numbersToReturn, array $allMovies, array $expectedMovies): void
    {
        $numberOfMoviesToRecommend = 3;
        $this->randomNumberGenerator->method('generate')->willReturn($numbersToReturn);

        $recommendedMovies = $this->algorithm->getRecommendations($numberOfMoviesToRecommend, $allMovies);

        self::assertEqualsCanonicalizing($expectedMovies, $recommendedMovies);
    }

    public static function getRecommendationsDataProvider(): array
    {
        return [
            'number_of_recommendations_is_same_length_as_array' => [[], ['W0', 'w', 'W1', 'w', 'W2'], ['W0', 'W1', 'W2']],
            'different_number_of_recommendations' => [[0,1,4], ['Incepcja', 'W0', 'w1', 'Shrek', 'w4' , 'Something'], ['W0', 'w1', 'w4']],
        ];
    }

    // TODO: add
}
