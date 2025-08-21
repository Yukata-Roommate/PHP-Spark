<?php

namespace Spark\Proxies;

use Spark\Foundation\Proxy\MethodProxy;

use Spark\Proxies\Managers\CacheManager;

/**
 * Cache Proxy
 *
 * @package Spark\Proxies
 *
 * @method static \Spark\Contracts\Cache\FileDriver file(string $directory)
 * @method static \Spark\Contracts\Cache\MemoryDriver file(int|null $maxItems = null, int|null $memoryLimit = null)
 *
 * @see \Spark\Proxies\Managers\CacheManager
 */
class Cache extends MethodProxy
{
    /**
     * proxy target
     *
     * @var string
     */
    protected string $proxyTarget = CacheManager::class;
}
