<?php

namespace Spark\Contracts\Cache;

use Spark\Contracts\Cache\Driver;

/**
 * File Driver Contract
 *
 * @package Spark\Contracts\Cache
 */
interface FileDriver extends Driver
{
    /*----------------------------------------*
     * Storage
     *----------------------------------------*/

    /**
     * Set cache directory
     *
     * @param string $directory
     * @return static
     */
    public function setDirectory(string $directory): static;

    /**
     * Get disk usage in bytes
     *
     * @return int
     */
    public function diskUsage(): int;

    /**
     * Get cache files count
     *
     * @return int
     */
    public function count(): int;
}
