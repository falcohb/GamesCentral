<?php

declare(strict_types=1);

namespace App\DTO;

final readonly class FeedSource
{
    public function __construct(
        public string $name,
        public string $url,
        public string $displayName,
    ) {}
}