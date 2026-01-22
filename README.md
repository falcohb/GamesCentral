# GamesCentral

> **Video Game News Aggregator** — All French gaming news on a single page

[![PHP](https://img.shields.io/badge/PHP-8.4+-777BB4?style=flat-square&logo=php&logoColor=white)](https://www.php.net/)
[![Symfony](https://img.shields.io/badge/Symfony-8.0-000000?style=flat-square&logo=symfony&logoColor=white)](https://symfony.com/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white)](https://tailwindcss.com/)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

---

## Overview

**GamesCentral** is an RSS aggregator that centralizes news from major French-speaking video game websites. The application fetches, caches, and displays articles with a modern **cyberpunk/gaming** styled interface.

### Aggregated Sources

| Source | Description |
|--------|-------------|
| [Gamekult](https://www.gamekult.com/) | Reviews, previews and news |
| [JeuxVideo.com](https://www.jeuxvideo.com/) | The largest French gaming website |
| [IGN France](https://fr.ign.com/) | International gaming news |
| [Gameblog](https://www.gameblog.fr/) | Independent news and reviews |
| [JeuxOnline](https://www.jeuxonline.info/) | MMO and online games specialist |
| [Gamergen](https://gamergen.com/) | Multi-platform news |

---

## Features

- **RSS Aggregation** — Automatic feed fetching with 5-minute cache
- **Chronological Sorting** — Articles sorted by day (today, yesterday, two days ago)
- **Popular Tags** — Automatic trending topic extraction from titles
- **Source Filtering** — Enable/disable sources in real-time
- **Tag Filtering** — Navigate by keyword
- **Visual Statistics** — Article distribution chart by source
- **Responsive Design** — Mobile, tablet and desktop adapted interface
- **Cyberpunk Theme** — Custom neon colors per source

---

## Requirements

- **PHP 8.4+** with `ctype`, `iconv` extensions
- **Composer** 2.x
- **Node.js** (optional, for Tailwind development)
- **Docker** and **Docker Compose** (recommended for PostgreSQL)

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/your-username/gamescentral.git
cd gamescentral
```

### 2. Install dependencies

```bash
composer install
```

### 3. Configure the environment

Copy the environment file and customize it:

```bash
cp .env .env.local
```

Configure the variables in `.env.local`:

```env
APP_ENV=dev
APP_SECRET=your_secret_here
APP_TIMEZONE=Europe/Brussels

# Database
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"

# RSS Feeds
RSS_GAMEKULT=https://www.gamekult.com/feed.xml
RSS_JEUXVIDEO=https://www.jeuxvideo.com/rss/rss.xml
RSS_IGN=https://fr.ign.com/feed.xml
RSS_GAMEBLOG=https://www.gameblog.fr/rss.php
RSS_JEUXONLINE=https://www.jeuxonline.info/rss/actu.xml
RSS_GAMERGEN=https://gamergen.com/rss
```

### 4. Start Docker services

```bash
docker-compose up -d
```

### 5. Build CSS assets

```bash
php bin/console tailwind:build
```

### 6. Start the development server

```bash
symfony server:start
# or
php -S localhost:8000 -t public/
```

The application is available at **http://localhost:8000**

---

## Useful Commands

```bash
# Development (via Makefile)
make run                              # Start Symfony server (daemon)
make abort                            # Stop Symfony server
make php-stan                         # Run PHPStan analysis

# Development (manual)
php bin/console cache:clear           # Clear Symfony cache
php bin/console tailwind:build        # Build Tailwind CSS
php bin/console tailwind:build -w     # Watch mode (auto-rebuild)

# Static Analysis
./vendor/bin/phpstan analyse          # Run PHPStan (level 8)

# Debugging
php bin/console debug:router          # List routes
php bin/console debug:container       # List services
tail -f var/log/dev.log               # Follow logs

# Database
php bin/console doctrine:migrations:migrate   # Run migrations

# Tests
./vendor/bin/phpunit                  # Run all tests
./vendor/bin/phpunit tests/Unit/      # Unit tests only
```

---

## Architecture

```
gamescentral/
├── config/
│   ├── services.yaml          # Services configuration and RSS injection
│   └── packages/              # Bundle configuration
├── public/
│   └── img/                   # Static assets (logo, favicon)
├── src/
│   ├── Config/
│   │   ├── game_franchises.php    # ~100 game franchise patterns
│   │   └── game_studios.php       # ~90 studio/publisher patterns
│   ├── Controller/
│   │   └── HomeController.php     # Main routes (/, /tag/{tag}, /api/counts)
│   ├── DTO/
│   │   ├── Article.php            # Article Data Transfer Object (readonly)
│   │   └── FeedSource.php         # RSS source configuration
│   ├── Service/
│   │   ├── RssFeedAggregator.php  # RSS feed aggregation and caching
│   │   ├── TagExtractor.php       # Tag extraction from titles
│   │   └── TagExtractorFactory.php # Factory for TagExtractor
│   └── Twig/
│       └── AppExtension.php       # Custom Twig filters and functions
├── templates/
│   ├── base.html.twig         # Main layout
│   └── home/
│       └── index.html.twig    # Homepage
├── assets/
│   ├── app.js                 # Main JavaScript (Stimulus)
│   └── styles/
│       └── app.css            # Tailwind styles + cyberpunk theme
└── Makefile                   # Development commands (run, abort, php-stan)
```

### Data Flow

```
┌─────────────┐     ┌──────────────────────┐     ┌────────────────┐
│  RSS Feeds  │────▶│  RssFeedAggregator   │────▶│ HomeController │
│  (6 sources)│     │  (5 min cache)       │     │                │
└─────────────┘     └──────────────────────┘     └───────┬────────┘
                              │                          │
                              ▼                          ▼
                    ┌──────────────────┐        ┌───────────────┐
                    │   TagExtractor   │        │ Twig Template │
                    │ (title analysis) │        │   (render)    │
                    └──────────────────┘        └───────────────┘
```

### Tag Extraction

The `TagExtractor` service analyzes article titles to extract trending topics:

1. **Known Franchises** — Matches ~100 game franchise patterns (Call of Duty, Zelda, Final Fantasy, etc.)
2. **Known Studios** — Matches ~90 studio/publisher patterns (Ubisoft, Rockstar, Capcom, etc.)
3. **Generic Names** — Extracts capitalized word sequences as potential game titles
4. **Filtering** — Excludes common words, geographic names, and requires minimum occurrences (2+)

Patterns are defined in `src/Config/game_franchises.php` and `src/Config/game_studios.php` for easy maintenance.

---

## Tech Stack

| Category | Technologies |
|----------|-------------|
| **Backend** | PHP 8.4, Symfony 8.0, Doctrine ORM |
| **RSS** | Laminas Feed |
| **Frontend** | Twig, Tailwind CSS, Stimulus.js, Turbo.js |
| **Assets** | Symfony Asset Mapper |
| **Charts** | Chart.js |
| **Cache** | Symfony Cache (filesystem) |
| **Database** | PostgreSQL 16 |
| **Static Analysis** | PHPStan (level 8) |
| **Dev Tools** | Docker, Mailpit, Makefile |

---

## API

### GET `/api/counts`

Returns today's article count per source.

**Response:**
```json
{
  "gamekult": 12,
  "jvcom": 25,
  "ign": 8,
  "gameblog": 15,
  "jeuxonline": 5,
  "gamergen": 10
}
```

---

## Customization

### Adding a new RSS source

1. Add the URL in `.env`:
   ```env
   RSS_NEW_SOURCE=https://example.com/rss.xml
   ```

2. Declare the parameter in `config/services.yaml`:
   ```yaml
   parameters:
       rss.new_source: '%env(RSS_NEW_SOURCE)%'
   ```

3. Add the source in `RssFeedAggregator.php`:
   ```php
   new FeedSource('new_source', $newSourceUrl, 'New Source'),
   ```

4. Define the color in `app.css`:
   ```css
   .nav-new_source { --nav-color: #ff00ff; }
   .article-cyber.new_source { --source-color: #ff00ff; }
   ```

---

## Author

**Olivier Maloteau** — [weebee.be](https://www.weebee.be/)

---

## License

This project is licensed under the [MIT License](LICENSE).

---

<p align="center">
  <sub>GamesCentral — Since 2011</sub>
</p>