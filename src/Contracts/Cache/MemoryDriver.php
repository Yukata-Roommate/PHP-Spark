<?php

namespace Spark\Contracts\Cache;

use Spark\Contracts\Cache\Driver;

/**
 * Memory Driver Contract
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
     */
    public function setMaxItems(int|null $maxItems): static;

    /**
     * Set storage memory limit in bytes
     *
     * @param int|null $memoryLimit
     * @return static
     */
    public function setMemoryLimit(int|null $memoryLimit): static;

    /**
     * Get memory usage in bytes
     *
     * @return int
     */
    public function memoryUsage(): int;
}
