<?php

declare(strict_types=1);

namespace Spark\Proxies;

use Spark\Foundation\Proxy\MethodProxy;

use Spark\Proxies\Managers\CacheManager;

/**
 * Cache Proxy
 *
 * @package Spark\Proxies
 *
 * @method static \Spark\Contracts\Cache\FileDriver file(string $directory)
 * @method static \Spark\Contracts\Cache\MemoryDriver memory(int|null $maxItems = null, int|null $memoryLimit = null)
 *
 * @see \Spark\Proxies\Managers\CacheManager
 */
class Cache extends MethodProxy
{
    /**
     * Proxy target
     *
     * @var string
     */
    protected string $proxyTarget = CacheManager::class;
}
