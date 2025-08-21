<?php

namespace Spark\Proxies;

use Spark\Foundation\Proxy\MethodProxy;

use Spark\Proxies\Managers\SupportsManager;

/**
 * Timer Proxy
 *
 * @package Spark\Proxies
 *
 * @method static \Spark\Proxies\Managers\Supports\GlobalManager global()
 * @method static \Spark\Proxies\Managers\Supports\EnvManager env()
 *
 * @see \Spark\Proxies\Managers\SupportsManager
 */
class Supports extends MethodProxy
{
    /**
     * proxy target
     *
     * @var string
     */
    protected string $proxyTarget = SupportsManager::class;
}
