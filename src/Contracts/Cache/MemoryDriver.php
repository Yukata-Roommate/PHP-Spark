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
     * set storage max items
     *
     * @param int|null $maxItems
     * @return static
     */
    public function setMaxItems(int|null $maxItems): static;

    /**
     * set storage memory limit
     *
     * @param int|null $memoryLimit
     * @return static
     */
    public function setMemoryLimit(int|null $memoryLimit): static;

    /**
     * get memory usage
     *
     * @return int
     */
    public function memoryUsage(): int;
}
