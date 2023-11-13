<?php

declare(strict_types=1);

namespace App\Tests\Algorithm;

use App\RecommendationAlgorithm\RandomRecommendation;
use App\Util\Const\Movies;
use App\Util\Const\RecommendationTypes;
use App\Util\Generator\NonRepetitiveRandomNumberGenerator;
use LogicException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class RandomRecommendationAlgorithmTest extends TestCase
{
    private MockObject&NonRepetitiveRandomNumberGenerator $randomNumberGenerator;
    private RandomRecommendation $algorithm;

    protected function setUp(): void
    {
        $this->randomNumberGenerator = $this->createMock(NonRepetitiveRandomNumberGenerator::class);
        $this->algorithm = new RandomRecommendation($this->randomNumberGenerator);
    }

    public function testSupportedType(): void
    {
        self::assertTrue($this->algorithm->supports(RecommendationTypes::RANDOM));
    }

    /**
     * @dataProvider exceptionDataProvider
     */
    public function testThrownExceptions(int $requested, array $titles): void
    {
        self::expectException(LogicException::class);

        $this->algorithm->getRecommendations($requested, $titles);
    }

    public static function exceptionDataProvider(): array
    {
        return [
            'number_of_available_entries_is_lower_than_requested' => [5, ['Shrek', 'Fiona', 'Donkey']],
        ];
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
            'number_of_recommendations_is_same_length_as_array' => [[], ['a', 'b', 'c'], ['a', 'b', 'c']],
            'different_number_of_recommendations' => [[0,1,4], ['a', 'b', 'c', 'd' , 'e'], ['a', 'b', 'e']],
            '3_movies' => [[0, 7, 13], Movies::MOVIES, ['Pulp Fiction', 'Leon zawodowiec', 'Chłopaki nie płaczą']],
        ];
    }
}
