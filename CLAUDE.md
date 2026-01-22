# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

GamesCentral is a French gaming news RSS aggregator built with Symfony 8.0 and PHP 8.4+. It fetches and displays articles from 6 gaming news sources (Gamekult, JeuxVideo.com, IGN France, Gameblog, JeuxOnline, Gamergen) with tag extraction and filtering capabilities.

## Commands

```bash
# Development
make run                          # Start Symfony server (daemon mode)
make abort                        # Stop Symfony server
docker-compose up -d              # Start PostgreSQL + Mailpit
composer install                  # Install dependencies
php bin/console cache:clear       # Clear Symfony cache
php bin/console tailwind:build    # Build Tailwind CSS
php bin/console tailwind:build --watch  # Watch mode for CSS

# Static Analysis
make php-stan                     # Run PHPStan (level 8)
./vendor/bin/phpstan analyse      # Run PHPStan directly

# Testing
./vendor/bin/phpunit              # Run all tests
./vendor/bin/phpunit tests/Path/To/TestFile.php  # Run single test file

# Debugging
php bin/console debug:router      # List routes
php bin/console debug:container   # List services
tail -f var/log/dev.log           # View logs

# Database
php bin/console doctrine:migrations:migrate
```

## Architecture

```
src/
├── Config/
│   ├── game_franchises.php         # Game franchise patterns for tag extraction
│   └── game_studios.php            # Game studio patterns for tag extraction
├── Controller/HomeController.php   # Routes: /, /tag/{tag}, /api/counts
├── Service/
│   ├── RssFeedAggregator.php       # RSS fetching with 5-min cache (Laminas Feed)
│   ├── TagExtractor.php            # Tag extraction from article titles
│   └── TagExtractorFactory.php     # Factory to inject config into TagExtractor
├── DTO/
│   ├── Article.php                 # Immutable article data object
│   └── FeedSource.php              # RSS source configuration
└── Twig/AppExtension.php           # Filters: time_ago, tag_font_size
                                    # Functions: today(), yesterday(), two_days_ago()
```

**Data Flow:** RSS feeds → RssFeedAggregator (cached) → HomeController → Twig templates

**Tag Extraction Flow:** Article titles → TagExtractor → Known franchises (from config) → Known studios (from config) → Generic capitalized words → Filtered by occurrences

**Frontend Stack:** Tailwind CSS (via tailwind-bundle), Stimulus.js, Turbo.js, Asset Mapper, Chart.js (CDN)

## Configuration

RSS feed URLs are defined in `.env` and injected via `config/services.yaml`:
- `APP_TIMEZONE=Europe/Brussels`
- `RSS_GAMEKULT`, `RSS_JEUXVIDEO`, `RSS_IGN`, `RSS_GAMEBLOG`, `RSS_JEUXONLINE`, `RSS_GAMERGEN`

Game franchises and studios patterns are defined in:
- `src/Config/game_franchises.php` - ~100 game franchise patterns
- `src/Config/game_studios.php` - ~90 studio/publisher patterns

## Code Conventions

- Strict types: `declare(strict_types=1);` in all PHP files
- DTOs use `readonly` properties
- Services use constructor injection
- RSS fetch failures are logged and gracefully handled (no exceptions thrown to user)
- Templates use cyberpunk/gaming theme with source-specific neon colors
- PHPStan level 8 compliance required
- HTML entities in RSS feeds are double-decoded (some feeds double-encode)

## Turbo.js Compatibility

JavaScript that needs to run after page navigation must use `turbo:load` event instead of `DOMContentLoaded`:
```javascript
document.addEventListener('turbo:load', function() {
    // Code here runs on initial load AND after Turbo navigation
});
```
