<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\RssFeedAggregator;
use App\Service\TagExtractor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    public function __construct(
        private readonly RssFeedAggregator $feedAggregator,
        private readonly TagExtractor $tagExtractor,
    ) {
    }

    #[Route('/', name: 'home')]
    #[Route('/tag/{tag}', name: 'search')]
    public function index(?string $tag = null): Response
    {
        $feedData = $this->feedAggregator->fetchAll();
        $articles = $feedData['articles'];

        // Extract popular tags
        $tags = $this->tagExtractor->extract($articles);

        // Filter by tag if provided
        if (null !== $tag) {
            $articles = $this->tagExtractor->filterByTag($articles, $tag);
        }

        return $this->render('home/index.html.twig', [
            'articles' => $articles,
            'tags' => $tags,
            'counts' => $feedData['counts'],
            'totalCount' => $feedData['totalCount'],
            'currentTag' => $tag,
            'sources' => $this->feedAggregator,
        ]);
    }

    #[Route('/api/counts', name: 'api_counts', methods: ['GET'])]
    public function counts(): Response
    {
        $feedData = $this->feedAggregator->fetchAll();

        return $this->json($feedData['counts']);
    }
}
