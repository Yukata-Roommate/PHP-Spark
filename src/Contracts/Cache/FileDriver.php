<?php

declare(strict_types=1);

namespace Spark\Contracts\Cache;

use Spark\Contracts\Cache\Driver;

/**
 * File Cache Driver Contract
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
     * @throws \Spark\Exceptions\Cache\DirectoryCreateException
     */
    public function setDirectory(string $directory): static;

    /**
     * Get cache directory
     *
     * @return string
     */
    public function directory(): string;

    /**
     * Get disk usage in bytes
     *
     * @return int
     */
    public function diskUsage(): int;
}
