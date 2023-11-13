<?php

declare(strict_types=1);

namespace App\Tests\Algorithm;

use App\RecommendationAlgorithm\MultipleWordsInTitleRecommendation;
use App\Util\Const\Movies;
use App\Util\Const\RecommendationTypes;
use App\Util\Generator\NonRepetitiveRandomNumberGenerator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class MultipleWordsInTitleRecommendationTest extends TestCase
{
    private MockObject&NonRepetitiveRandomNumberGenerator $randomNumberGenerator;
    private ?MultipleWordsInTitleRecommendation $algorithm;

    protected function setUp(): void
    {
        $this->randomNumberGenerator = $this->createMock(NonRepetitiveRandomNumberGenerator::class);
        $this->algorithm = new MultipleWordsInTitleRecommendation($this->randomNumberGenerator);
    }

    public function testSupportedType(): void
    {
        self::assertTrue($this->algorithm->supports(RecommendationTypes::MULTIPLE_WORDS_IN_TITLE));
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
                [],
                ['One', 'Single Siren', 'Word', 'Great Shrek', 'Something', 'Great Inception',],
                ['Single Siren', 'Great Shrek', 'Great Inception'],
            ],
            'different_number_of_recommendations' => [
                3,
                [0, 1, 4],
                ['First Great Movie', 'Second Great Movie', 'Third Great Movie', 'Fourth Great Movie', 'Fifth Great Movie'],
                ['First Great Movie', 'Second Great Movie', 'Fifth Great Movie']],
            '3_movies' => [
                3,
                [0, 3, 7],
                Movies::MOVIES,
                [
                    'Doktor Strange',
                    'Ojciec chrzestny',
                    'Pulp Fiction',
                ],
            ],
            'all_movies' => [
                28,
                [],
                Movies::MOVIES,
                self::getAllMoviesWithTwoWords(),
            ]
        ];
    }

    public static function getAllMoviesWithTwoWords(): array
    {
        return [
            'American Beauty',
            'Blade Runner',
            'Breaking Bad',
            'Casino Royale',
            'Doktor Strange',
            'Dwunastu gniewnych ludzi',
            'Fight Club',
            'Forest Gump',
            'Forrest Gump',
            'Gran Torino',
            'Green Mile',
            'La La Land',
            'Leon zawodowiec',
            'Milczenie owiec',
            'Mroczny Rycerz',
            'Nagi instynkt',
            'Ojciec chrzestny',
            'Pulp Fiction',
            'Requiem dla snu',
            'Siedem dusz',
            'Sin City',
            'Skazani na Shawshank',
            'Skazany na bluesa',
            'Szeregowiec Ryan',
            'Truman Show',
            'Wielki Gatsby',
            'Wyspa tajemnic',
            'Zielona mila',
        ];
    }
}
