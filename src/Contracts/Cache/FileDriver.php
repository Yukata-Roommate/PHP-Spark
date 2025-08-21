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
     * set cache directory
     *
     * @param string $directory
     * @return static
     */
    public function setDirectory(string $directory): static;

    /**
     * get disk usage
     *
     * @return int
     */
    public function diskUsage(): int;

    /**
     * get cache files count
     *
     * @return int
     */
    public function count(): int;
}
