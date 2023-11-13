<?php

declare(strict_types=1);

namespace App\Controller;

use App\Provider\Interface\RecommendationProviderInterface;
use App\Util\Const\RecommendationTypes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class RecommendationsController extends AbstractController
{
    public function __construct(
        private readonly RecommendationProviderInterface $recommendationProvider,
    ) {
    }

    #[Route(path: '/movies/recommendations', name: 'movie_recommendations', methods: [Request::METHOD_GET])]
    public function __invoke(
        #[MapQueryParameter] string $type = RecommendationTypes::RANDOM,
        #[MapQueryParameter] int $number = 3,
    ): JsonResponse
    {
        return $this->json($this->recommendationProvider->provide($type, $number));
    }
}
