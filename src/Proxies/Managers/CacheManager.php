<?php

declare(strict_types=1);

namespace Spark\Proxies\Managers;

use Spark\Foundation\Proxy\ProxyManager;

use Spark\Contracts\Cache\FileDriver as FileDriverContract;
use Spark\Cache\FileDriver;

use Spark\Contracts\Cache\MemoryDriver as MemoryDriverContract;
use Spark\Cache\MemoryDriver;

/**
 * Cache Proxy Manager
 *
 * @package Spark\Proxies\Managers
 */
class CacheManager extends ProxyManager
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * Init manager
     *
     * @return void
     */
    protected function init(): void {}

    /*----------------------------------------*
     * Accessor
     *----------------------------------------*/

    /**
     * Get file cache driver
     *
     * @param string $directory
     * @return \Spark\Contracts\Cache\FileDriver
     */
    public function file(string $directory): FileDriverContract
    {
        return new FileDriver($directory);
    }

    /**
     * Get memory cache driver
     *
     * @param int|null $maxItems
     * @param int|null $memoryLimit
     * @return \Spark\Contracts\Cache\MemoryDriver
     */
    public function memory(int|null $maxItems = null, int|null $memoryLimit = null): MemoryDriverContract
    {
        return new MemoryDriver($maxItems, $memoryLimit);
    }
}
