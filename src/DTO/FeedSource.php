<?php

declare(strict_types=1);

/*
 * This file is part of a Symfony Application built by Enabel.
 * Copyright (c) Enabel <https://github.com/Enabel>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DTO;

final readonly class FeedSource
{
    public function __construct(
        public string $name,
        public string $url,
        public string $displayName,
    ) {
    }
}
