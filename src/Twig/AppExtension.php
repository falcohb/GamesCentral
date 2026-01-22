<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('time_ago', $this->timeAgo(...)),
            new TwigFilter('convert_seconds', $this->convertSeconds(...)),
            new TwigFilter('tag_font_size', $this->tagFontSize(...)),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('today', $this->getToday(...)),
            new TwigFunction('yesterday', $this->getYesterday(...)),
            new TwigFunction('two_days_ago', $this->getTwoDaysAgo(...)),
        ];
    }

    /**
     * Converts a timestamp/datetime string to a French relative time.
     */
    public function timeAgo(string|\DateTimeInterface $timestamp): string
    {
        $now = time();

        if ($timestamp instanceof \DateTimeInterface) {
            $ts = $timestamp->getTimestamp();
        } else {
            $ts = strtotime($timestamp);
        }

        $diff = $now - $ts;

        if ($diff <= 60) {
            return '1 minute';
        }

        if ($diff < 3600) {
            $minutes = (int) floor($diff / 60);
            return $minutes . ' minute' . ($minutes > 1 ? 's' : '');
        }

        if ($diff < 86400) {
            $hours = (int) floor($diff / 3600);
            return $hours . ' heure' . ($hours > 1 ? 's' : '');
        }

        $days = (int) floor($diff / 86400);
        return $days . ' jour' . ($days > 1 ? 's' : '');
    }

    /**
     * Converts seconds to HH:MM:SS format.
     */
    public function convertSeconds(int $seconds): string
    {
        return gmdate('H:i:s', $seconds);
    }

    /**
     * Returns the appropriate font size for a tag based on its count.
     */
    public function tagFontSize(int $count): string
    {
        return match (true) {
            $count >= 6 => '0.9rem',
            $count === 5 => '0.85rem',
            $count === 4 => '0.8rem',
            $count === 3 => '0.75rem',
            default => '0.7rem',
        };
    }

    public function getToday(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('today', new \DateTimeZone('Europe/Brussels'));
    }

    public function getYesterday(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('yesterday', new \DateTimeZone('Europe/Brussels'));
    }

    public function getTwoDaysAgo(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('-2 days', new \DateTimeZone('Europe/Brussels'));
    }
}
