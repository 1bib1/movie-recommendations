<?php

declare(strict_types=1);

namespace App\Tests\Algorithm;

use App\RecommendationAlgorithm\MultipleWordsInTitleRecommendation;
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
            'number_of_recommendations_is_same_length_as_array' => [
                [],
                ['One', 'Single Siren', 'Word', 'Great Shrek', 'Something', 'Great Inception',],
                ['Single Siren', 'Great Shrek', 'Great Inception'],
            ],
            'different_number_of_recommendations' => [
                [0,1,4],
                ['First Great Movie', 'Second Great Movie', 'Third Great Movie', 'Fourth Great Movie', 'Fifth Great Movie'],
                ['First Great Movie', 'Second Great Movie', 'Fifth Great Movie']],
        ];
    }

    // TODO: add tests with Movies const
}
