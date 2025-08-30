<?php

declare(strict_types=1);

namespace Spark\Foundation\Monitor\Metrics;

use Spark\Contracts\Monitor\Metrics as MetricsContract;

/**
 * Metrics
 *
 * @package Spark\Foundation\Monitor\Metrics
 */
abstract class Metrics implements MetricsContract
{
    /*----------------------------------------*
     * Format
     *----------------------------------------*/

    /**
     * Format bytes
     *
     * @param int $bytes
     * @return string
     */
    protected function formatBytes(int $bytes): string
    {
        return match (true) {
            $bytes < 1024 ** 1 => "{$bytes} B",
            $bytes < 1024 ** 2 => sprintf("%.2f KB", $bytes / 1024),
            $bytes < 1024 ** 3 => sprintf("%.2f MB", $bytes / (1024 ** 2)),
            $bytes < 1024 ** 4 => sprintf("%.2f GB", $bytes / (1024 ** 3)),

            default => sprintf("%.2f TB", $bytes / (1024 ** 4)),
        };
    }

    /**
     * Format percentage
     *
     * @param float $percentage
     * @return string
     */
    protected function formatPercentage(float $percentage): string
    {
        return sprintf("%.2f%%", $percentage * 100);
    }

    /**
     * Format seconds
     *
     * Param int $seconds
     * @return string
     */
    protected function formatSeconds(int $seconds): string
    {
        $days    = floor($seconds / 86400);
        $hours   = floor(($seconds % 86400) / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $seconds = $seconds % 60;

        $parts = [];
        if ($days > 0) $parts[] = "{$days} day" . ($days > 1 ? "s" : "");
        if ($hours > 0) $parts[] = "{$hours} hour" . ($hours > 1 ? "s" : "");
        if ($minutes > 0) $parts[] = "{$minutes} minute" . ($minutes > 1 ? "s" : "");
        $parts[] = "{$seconds} second" . ($seconds > 1 ? "s" : "");

        return implode(", ", $parts) ?: "0 seconds";
    }
}
