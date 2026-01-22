<?php

declare(strict_types=1);

namespace App\Service;

final readonly class TagExtractorFactory
{
    public function __construct(
        private string $gameFranchisesPath,
        private string $gameStudiosPath,
    ) {
    }

    public function create(): TagExtractor
    {
        /** @var array<string, array{franchise: string, pattern: string}> $gameFranchises */
        $gameFranchises = require $this->gameFranchisesPath;

        /** @var array<string, string> $gameStudios */
        $gameStudios = require $this->gameStudiosPath;

        return new TagExtractor($gameFranchises, $gameStudios);
    }
}
