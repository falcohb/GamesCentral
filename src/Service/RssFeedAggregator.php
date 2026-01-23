<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Article;
use App\DTO\FeedSource;
use Laminas\Feed\Reader\Reader;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class RssFeedAggregator
{
    private const CACHE_TTL = 300; // 5 minutes

    /** @var array<FeedSource> */
    public array $sources {
        get {
            return $this->sources;
        }
    }

    public function __construct(
        private readonly CacheInterface $cache,
        private readonly LoggerInterface $logger,
        private readonly string $timezone = 'Europe/Brussels',
        string $gamekultUrl = '',
        string $jeuxvideoUrl = '',
        string $ignUrl = '',
        string $gameblogUrl = '',
        string $jeuxonlineUrl = '',
        string $gamergenUrl = '',
    ) {
        $this->sources = [
            new FeedSource('gamekult', $gamekultUrl, 'Gamekult'),
            new FeedSource('jvcom', $jeuxvideoUrl, 'JeuxVideo.com'),
            new FeedSource('ign', $ignUrl, 'IGN France'),
            new FeedSource('gameblog', $gameblogUrl, 'Gameblog'),
            new FeedSource('jeuxonline', $jeuxonlineUrl, 'JeuxOnline'),
            new FeedSource('gamergen', $gamergenUrl, 'Gamergen'),
        ];
    }

    /**
     * @return array{articles: array<Article>, counts: array<string, int>, totalCount: int}
     */
    public function fetchAll(): array
    {
        return $this->cache->get('rss_feed_all', function (ItemInterface $item): array {
            $item->expiresAfter(self::CACHE_TTL);

            $articles = [];
            $counts = [];
            $today = $this->getToday();

            foreach ($this->sources as $source) {
                if (empty($source->url)) {
                    continue;
                }

                try {
                    $feedArticles = $this->fetchFeed($source);
                    $articles = array_merge($articles, $feedArticles);

                    // Count today's articles
                    $counts[$source->name] = count(array_filter(
                        $feedArticles,
                        fn (Article $a) => $a->isFromToday($today),
                    ));
                } catch (\Exception $e) {
                    $this->logger->error('Failed to fetch RSS feed', [
                        'source' => $source->name,
                        'url' => $source->url,
                        'error' => $e->getMessage(),
                    ]);
                    $counts[$source->name] = 0;
                }
            }

            // Sort by publication date (newest first)
            usort($articles, fn (Article $a, Article $b) => $b->publishedAt <=> $a->publishedAt);

            return [
                'articles' => $articles,
                'counts' => $counts,
                'totalCount' => array_sum($counts),
            ];
        });
    }

    /**
     * @return array<Article>
     */
    private function fetchFeed(FeedSource $source): array
    {
        $feed = Reader::import($source->url);
        $articles = [];
        $tz = new \DateTimeZone($this->timezone);

        foreach ($feed as $item) {
            $date = $item->getDateModified() ?? $item->getDateCreated();

            if (!$date instanceof \DateTime) {
                continue;
            }

            $publishedAt = \DateTimeImmutable::createFromMutable($date)
                ->setTimezone($tz);

            // Double decode for feeds with double-encoded entities (e.g., &amp;#x27; -> &#x27; -> ')
            $rawTitle = $item->getTitle();
            $rawDescription = $item->getDescription();
            $rawLink = $item->getLink();

            $title = is_string($rawTitle) ? html_entity_decode(html_entity_decode($rawTitle, ENT_QUOTES | ENT_HTML5, 'UTF-8'), ENT_QUOTES | ENT_HTML5, 'UTF-8') : '';
            $description = is_string($rawDescription) ? html_entity_decode(html_entity_decode($rawDescription, ENT_QUOTES | ENT_HTML5, 'UTF-8'), ENT_QUOTES | ENT_HTML5, 'UTF-8') : '';
            $link = is_string($rawLink) ? $rawLink : '';

            $articles[] = new Article(
                title: $title,
                link: $link,
                description: $description,
                publishedAt: $publishedAt,
                source: $source->name,
            );
        }

        return $articles;
    }

    private function getToday(): \DateTimeImmutable
    {
        return (new \DateTimeImmutable('today', new \DateTimeZone($this->timezone)))
            ->setTime(0, 0);
    }

}
