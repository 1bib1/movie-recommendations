<?php

declare(strict_types=1);

namespace App\Tests\Algorithm;

use App\RecommendationAlgorithm\TitleStartWithWRecommendation;
use App\Util\Const\Movies;
use App\Util\Generator\NonRepetitiveRandomNumberGenerator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Asset\Package;

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
    public function testGetRecommendations(int $numberOfMoviesToRecommend, array $numbersToReturn, array $allMovies, array $expectedMovies): void
    {
        $this->randomNumberGenerator->method('generate')->willReturn($numbersToReturn);

        $recommendedMovies = $this->algorithm->getRecommendations($numberOfMoviesToRecommend, $allMovies);

        self::assertEqualsCanonicalizing($expectedMovies, $recommendedMovies);
    }

    public static function getRecommendationsDataProvider(): array
    {
        return [
            'number_of_recommendations_is_same_length_as_array' => [
                3,
                [], // should return without randomizing
                ['W0', 'w', 'W1', 'w', 'W2'],
                ['W0', 'W1', 'W2']],
            'different_number_of_recommendations' => [
                3,
                [0, 1, 4],
                ['Incepcja', 'W0', 'w1', 'Shrek', 'w4' , 'Something'],
                ['W0', 'w1', 'w4']
            ],
            'movie_recommendations' => [
                3,
                [],  // should return without randomizing, because there are only 3 matching movie titles
                Movies::MOVIES,
                [
                    'Whiplash',
                    'Wyspa tajemnic',
                    'Władca Pierścieni: Drużyna Pierścienia',
                ],
            ],
            '3_random_movies' => [
                3,
                [0, 1, 3],
                array_merge(Movies::MOVIES, ['Wonder Woman']),
                [
                    'Whiplash',
                    'Wyspa tajemnic',
                    'Wonder Woman',
                ],
            ],
        ];
    }
}
