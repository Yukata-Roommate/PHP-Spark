<?php

declare(strict_types=1);

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\CapacityException;

/**
 * Memory Limit Exceeded Exception
 *
 * @package Spark\Exceptions\Cache
 */
class MemoryLimitExceededException extends CapacityException
{
    /**
     * Requested memory in bytes
     *
     * @var int
     */
    protected int $requestedBytes;

    /**
     * Memory limit in bytes
     *
     * @var int
     */
    protected int $limitBytes;

    /**
     * Constructor
     *
     * @param int $requestedBytes
     * @param int $limitBytes
     */
    public function __construct(int $requestedBytes, int $limitBytes)
    {
        $this->requestedBytes = $requestedBytes;
        $this->limitBytes     = $limitBytes;

        parent::__construct(sprintf("Memory limit exceeded: requested %s, limit %s", $this->formatBytes($requestedBytes), $this->formatBytes($limitBytes)));
    }

    /**
     * Get requested bytes
     *
     * @return int
     */
    public function requestedBytes(): int
    {
        return $this->requestedBytes;
    }

    /**
     * Get limit bytes
     *
     * @return int
     */
    public function limitBytes(): int
    {
        return $this->limitBytes;
    }

    /**
     * Format bytes to human-readable string
     *
     * @param int $bytes
     * @return string
     */
    protected function formatBytes(int $bytes): string
    {
        $units     = ["B", "KB", "MB", "GB"];
        $unitIndex = 0;
        $value     = $bytes;

        while ($value >= 1024 && $unitIndex < count($units) - 1) {
            $value /= 1024;
            $unitIndex++;
        }

        return round($value, 2) . " " . $units[$unitIndex];
    }
}
