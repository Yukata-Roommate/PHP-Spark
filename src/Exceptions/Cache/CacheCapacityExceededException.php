<?php

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\CacheConfigurationException;

/**
 * Cache Capacity Exceeded Exception
 *
 * @package Spark\Exceptions\Cache
 */
class CacheCapacityExceededException extends CacheConfigurationException
{
    /**
     * The requested size in bytes
     *
     * @var int|null
     */
    protected int|null $requestedSize;

    /**
     * The available capacity in bytes
     *
     * @var int|null
     */
    protected int|null $availableCapacity;

    /**
     * The type of limit exceeded
     *
     * @var string
     */
    protected string $limitType;

    /**
     * Constructor
     *
     * @param string $message
     * @param string $limitType
     * @param int|null $requestedSize
     * @param int|null $availableCapacity
     */
    public function __construct(
        string $message,
        string $limitType = "memory",
        int|null $requestedSize = null,
        int|null $availableCapacity = null
    ) {
        $this->limitType = $limitType;
        $this->requestedSize = $requestedSize;
        $this->availableCapacity = $availableCapacity;

        if ($requestedSize !== null && $availableCapacity !== null) $message .= sprintf(
            " (requested: %s, available: %s)",
            $this->formatBytes($requestedSize),
            $this->formatBytes($availableCapacity)
        );

        parent::__construct($message);
    }

    /**
     * Get the limit type
     *
     * @return string
     */
    public function limitType(): string
    {
        return $this->limitType;
    }

    /**
     * Get the requested size
     *
     * @return int|null
     */
    public function requestedSize(): int|null
    {
        return $this->requestedSize;
    }

    /**
     * Get the available capacity
     *
     * @return int|null
     */
    public function availableCapacity(): int|null
    {
        return $this->availableCapacity;
    }

    /**
     * Format bytes to human-readable string
     *
     * @param int $bytes
     * @return string
     */
    protected function formatBytes(int $bytes): string
    {
        $units = ["B", "KB", "MB", "GB"];
        $unitIndex = 0;

        while ($bytes >= 1024 && $unitIndex < count($units) - 1) {
            $bytes /= 1024;
            $unitIndex++;
        }

        return round($bytes, 2) . " " . $units[$unitIndex];
    }
}
