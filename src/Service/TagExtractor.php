<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Article;

final readonly class TagExtractor
{
    private const array EXCLUDED_WORDS = [
        'le', 'la', 'les', 'des', 'un', 'une', 'du', 'de', 'au', 'aux',
        'et', 'ou', 'en', 'pour', 'avec', 'sans', 'sur', 'sous', 'dans',
        'ce', 'cette', 'ces', 'son', 'sa', 'ses', 'notre', 'nos',
        'the', 'a', 'an', 'of', 'to', 'and', 'or', 'for', 'with',
        'test', 'preview', 'review', 'news', 'actu', 'actualité', 'interview',
        'bon plan', 'promo', 'soldes', 'mise à jour', 'update', 'patch',
        'dlc', 'trailer', 'bande-annonce', 'vidéo', 'video', 'guide', 'tuto',
        'sortie', 'date', 'prix', 'gratuit', 'free', 'offert', 'exclu', 'exclusif',
        'ps4', 'ps5', 'xbox', 'switch', 'pc', 'steam', 'epic', 'playstation', 'nintendo',
        'chine', 'china', 'france', 'japon', 'japan', 'usa', 'europe', 'asie', 'amérique',
        'paris', 'tokyo', 'londres', 'london', 'berlin', 'new york',
        'jeu', 'jeux', 'game', 'games', 'gaming', 'joueur', 'joueurs', 'player', 'players',
        'forza', 'horizon',
        'nouveau', 'nouvelle', 'nouveaux', 'nouvelles', 'new', 'premier', 'première',
        'meilleur', 'meilleure', 'best', 'top', 'pire', 'worst',
        'année', 'year', 'mois', 'month', 'semaine', 'week', 'jour', 'day', 'mémoire',
    ];

    private const int MIN_OCCURRENCES = 2;
    private const int MIN_TAG_LENGTH = 3;
    private const int DAYS_LOOKBACK = 3;
    private const int MAX_GENERIC_TAG_WORDS = 4;

    /**
     * @param array<string, array{franchise: string, pattern: string}> $gameFranchises
     * @param array<string, string> $gameStudios
     */
    public function __construct(
        private array $gameFranchises,
        private array $gameStudios,
    ) {
    }

    /**
     * Extracts popular tags from article titles.
     *
     * @param array<Article> $articles
     *
     * @return array<string, int> Tags with their occurrence count
     */
    public function extract(array $articles): array
    {
        $cutoffDate = new \DateTimeImmutable(sprintf('-%d days', self::DAYS_LOOKBACK));
        $allTags = [];

        foreach ($articles as $article) {
            if ($article->publishedAt < $cutoffDate) {
                continue;
            }

            $tags = $this->extractTagsFromTitle($article->title);
            array_push($allTags, ...$tags);
        }

        $occurrences = array_count_values($allTags);

        // Filter tags that appear at least MIN_OCCURRENCES times
        $popularTags = array_filter(
            $occurrences,
            fn (int $count) => $count >= self::MIN_OCCURRENCES,
        );

        // Sort by occurrence count (descending)
        arsort($popularTags);

        return $popularTags;
    }

    /**
     * @return array<string>
     */
    private function extractTagsFromTitle(string $title): array
    {
        $tags = [];
        $remainingTitle = $title;

        // First, try to match known game franchises and remove them from title
        $franchiseResult = $this->extractKnownFranchises($title);
        $tags = array_merge($tags, $franchiseResult['tags']);
        $remainingTitle = $franchiseResult['remainingTitle'];

        // Then, try to match known game studios
        $studioResult = $this->extractKnownStudios($remainingTitle);
        $tags = array_merge($tags, $studioResult['tags']);
        $remainingTitle = $studioResult['remainingTitle'];

        // Finally, extract potential game names from the remaining title
        $genericTags = $this->extractGenericGameNames($remainingTitle);
        $tags = array_merge($tags, $genericTags);

        // Remove duplicates and clean up
        return array_unique(array_filter($tags, static fn (string $tag) => strlen($tag) >= self::MIN_TAG_LENGTH));
    }

    /**
     * Extract known game franchise names from the title.
     *
     * @return array{tags: array<string>, remainingTitle: string}
     */
    private function extractKnownFranchises(string $title): array
    {
        $tags = [];
        $remainingTitle = $title;

        foreach ($this->gameFranchises as $trigger => $config) {
            // Check if the trigger word is in the remaining title
            if (false === stripos($remainingTitle, $trigger)) {
                continue;
            }

            // Try to match the full pattern
            if (preg_match($config['pattern'], $remainingTitle, $matches)) {
                $fullName = trim($matches[0]);

                // Clean up the extracted name
                $fullName = $this->cleanGameName($fullName);

                // Limit to reasonable length (max ~50 chars for a game title)
                if (strlen($fullName) > 50) {
                    $fullName = $this->truncateToGameTitle($fullName);
                }

                if (strlen($fullName) >= self::MIN_TAG_LENGTH) {
                    $tags[] = $fullName;
                    // Remove the matched portion from the title to avoid duplicate extraction
                    $remainingTitle = str_ireplace($matches[0], ' ', $remainingTitle);
                }
            }
        }

        return [
            'tags' => $tags,
            'remainingTitle' => $remainingTitle,
        ];
    }

    /**
     * Extract known game studio names from the title.
     *
     * @return array{tags: array<string>, remainingTitle: string}
     */
    private function extractKnownStudios(string $title): array
    {
        $tags = [];
        $remainingTitle = $title;

        foreach ($this->gameStudios as $pattern) {
            // Try to match the pattern
            if (preg_match($pattern, $remainingTitle, $matches)) {
                $fullName = trim($matches[0]);

                // Clean up and normalize the studio name
                $fullName = $this->cleanGameName($fullName);

                if (strlen($fullName) >= self::MIN_TAG_LENGTH) {
                    $tags[] = $fullName;
                    // Remove the matched portion from the title
                    $remainingTitle = str_ireplace($matches[0], ' ', $remainingTitle);
                }
            }
        }

        return [
            'tags' => $tags,
            'remainingTitle' => $remainingTitle,
        ];
    }

    /**
     * Truncate a string to a reasonable game title length.
     * Cuts at natural boundaries (punctuation, common stop words).
     */
    private function truncateToGameTitle(string $name): string
    {
        // Cut at common title delimiters
        $delimiters = [' - ', ' : ', ' | ', ', ', ' – ', ' — '];
        foreach ($delimiters as $delimiter) {
            $pos = strpos($name, $delimiter);
            if (false !== $pos && $pos > 10) {
                $name = substr($name, 0, $pos);
                break;
            }
        }

        // If still too long, take first 5 words max
        $words = explode(' ', $name);
        if (count($words) > 5) {
            $name = implode(' ', array_slice($words, 0, 5));
        }

        return trim($name);
    }

    /**
     * Extract potential game names as sequences of capitalized words.
     *
     * @return array<string>
     */
    private function extractGenericGameNames(string $title): array
    {
        $tags = [];

        // Match sequences of capitalized words (potential game titles)
        // Matches: "Word Word 2", "Word: Subtitle", "Word's Word"
        preg_match_all(
            "/\b([A-Z][a-zàâäéèêëïîôùûüç]*(?:[''][a-zàâäéèêëïîôùûüç]+)?(?:\s*(?:[-:]\s*)?(?:[A-Z][a-zàâäéèêëïîôùûüç]*|[IVXLCDM]+|\d+))*)\b/u",
            $title,
            $matches,
        );

        foreach ($matches[0] as $match) {
            $tag = trim($match);

            // Skip if too short or too many words (likely a sentence, not a game name)
            $wordCount = str_word_count($tag);
            if ($wordCount > self::MAX_GENERIC_TAG_WORDS) {
                continue;
            }

            // Skip excluded words
            if ($this->isExcludedWord($tag)) {
                continue;
            }

            // Skip if it's just a single common word
            if (1 === $wordCount && strlen($tag) < 4) {
                continue;
            }

            if (strlen($tag) >= self::MIN_TAG_LENGTH) {
                $tags[] = $tag;
            }
        }

        return $tags;
    }

    /**
     * Clean up a game name by removing trailing punctuation and normalizing spaces.
     */
    private function cleanGameName(string $name): string
    {
        // Remove trailing punctuation except for numbers
        $name = preg_replace('/[:\-,\.]+$/', '', $name) ?? $name;

        // Normalize spaces
        $name = preg_replace('/\s+/', ' ', $name) ?? $name;

        // Trim and capitalize properly
        return trim($name);
    }

    /**
     * Check if a word/phrase should be excluded.
     */
    private function isExcludedWord(string $word): bool
    {
        $lowerWord = mb_strtolower($word);

        // Check exact match
        foreach (self::EXCLUDED_WORDS as $excluded) {
            if ($lowerWord === $excluded || $lowerWord === mb_strtolower($excluded)) {
                return true;
            }
        }

        // Check if any word in the phrase is excluded (for partial franchise names)
        $words = preg_split('/\s+/', $lowerWord);
        if (is_array($words)) {
            foreach ($words as $singleWord) {
                if (in_array($singleWord, self::EXCLUDED_WORDS, true)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Filter articles by tag.
     *
     * @param array<Article> $articles
     *
     * @return array<Article>
     */
    public function filterByTag(array $articles, string $tag): array
    {
        $decodedTag = urldecode($tag);

        return array_filter(
            $articles,
            fn (Article $article) => false !== stripos($article->title, $decodedTag),
        );
    }
}
