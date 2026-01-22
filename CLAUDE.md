# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

GamesCentral is a French gaming news RSS aggregator built with Symfony 8.0 and PHP 8.4+. It fetches and displays articles from 6 gaming news sources (Gamekult, JeuxVideo.com, JeuxVideo24, Gameblog, JeuxOnline, Gamergen) with tag extraction and filtering capabilities.

## Commands

```bash
# Development
docker-compose up -d              # Start PostgreSQL + Mailpit
composer install                  # Install dependencies
php bin/console cache:clear       # Clear Symfony cache
php bin/console tailwind:build    # Build Tailwind CSS
php bin/console tailwind:build --watch  # Watch mode for CSS

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
├── Controller/HomeController.php   # Routes: /, /tag/{tag}, /api/counts
├── Service/
│   ├── RssFeedAggregator.php       # RSS fetching with 5-min cache (Laminas Feed)
│   └── TagExtractor.php            # Tag extraction from article titles
├── DTO/
│   ├── Article.php                 # Immutable article data object
│   └── FeedSource.php              # RSS source configuration
└── Twig/AppExtension.php           # Filters: time_ago, tag_font_size
                                    # Functions: today(), yesterday(), two_days_ago()
```

**Data Flow:** RSS feeds → RssFeedAggregator (cached) → HomeController → Twig templates

**Frontend Stack:** Tailwind CSS (via tailwind-bundle), Stimulus.js, Turbo.js, Asset Mapper, Chart.js (CDN)

## Configuration

RSS feed URLs are defined in `.env` and injected via `config/services.yaml`:
- `APP_TIMEZONE=Europe/Brussels`
- `RSS_GAMEKULT`, `RSS_JEUXVIDEO`, `RSS_JEUXVIDEO24`, `RSS_GAMEBLOG`, `RSS_JEUXONLINE`, `RSS_GAMERGEN`

## Code Conventions

- Strict types: `declare(strict_types=1);` in all PHP files
- DTOs use `readonly` properties
- RSS fetch failures are logged and gracefully handled (no exceptions thrown to user)
- Templates use cyberpunk/gaming theme with source-specific neon colors
