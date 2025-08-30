<?php

declare(strict_types=1);

namespace Spark\Contracts\Cache;

use Spark\Contracts\Cache\Driver;

/**
 * Memory Cache Driver Contract
 *
 * @package Spark\Contracts\Cache
 */
interface MemoryDriver extends Driver
{
    /*----------------------------------------*
     * Storage
     *----------------------------------------*/

    /**
     * Set storage max items
     *
     * @param int|null $maxItems
     * @return static
     * @throws \Spark\Exceptions\Cache\InvalidMaxItemsException
     */
    public function setMaxItems(int|null $maxItems): static;

    /**
     * Get storage max items
     *
     * @return int|null
     */
    public function maxItems(): int|null;

    /**
     * Set storage memory limit in bytes
     *
     * @param int|null $memoryLimit
     * @return static
     * @throws \Spark\Exceptions\Cache\InvalidMemoryLimitException
     */
    public function setMemoryLimit(int|null $memoryLimit): static;

    /**
     * Get storage memory limit in bytes
     *
     * @return int|null
     */
    public function memoryLimit(): int|null;

    /**
     * Get memory usage in bytes
     *
     * @return int
     */
    public function memoryUsage(): int;
}
