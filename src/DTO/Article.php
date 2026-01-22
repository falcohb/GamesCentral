<?php

declare(strict_types=1);

namespace App\DTO;

final readonly class Article
{
    public function __construct(
        public string $title,
        public string $link,
        public string $description,
        public \DateTimeImmutable $publishedAt,
        public string $source,
    ) {}

    public function getPublishedAtString(): string
    {
        return $this->publishedAt->format('Y-m-d H:i:s');
    }

    public function isFromToday(\DateTimeImmutable $today): bool
    {
        return $this->publishedAt->format('Y-m-d') === $today->format('Y-m-d');
    }

    public function isFromYesterday(\DateTimeImmutable $today): bool
    {
        $yesterday = $today->modify('-1 day');
        return $this->publishedAt->format('Y-m-d') === $yesterday->format('Y-m-d');
    }

    public function isFromTwoDaysAgo(\DateTimeImmutable $today): bool
    {
        $twoDaysAgo = $today->modify('-2 days');
        return $this->publishedAt->format('Y-m-d') === $twoDaysAgo->format('Y-m-d');
    }
}
