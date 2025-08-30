<?php

declare(strict_types=1);

namespace Spark\Proxies;

use Spark\Foundation\Proxy\MethodProxy;

use Spark\Proxies\Managers\SuperglobalsManager;

/**
 * Superglobals Proxy
 *
 * @package Spark\Proxies
 *
 * @method static \Spark\Supports\Superglobals\Cookie cookie()
 * @method static \Spark\Supports\Superglobals\Env env()
 * @method static \Spark\Supports\Superglobals\Files files()
 * @method static \Spark\Supports\Superglobals\Get get()
 * @method static \Spark\Supports\Superglobals\Globals globals()
 * @method static \Spark\Supports\Superglobals\Post post()
 * @method static \Spark\Supports\Superglobals\Server server()
 * @method static \Spark\Supports\Superglobals\Session session()
 *
 * @see \Spark\Proxies\Managers\SuperglobalsManager
 */
class Superglobals extends MethodProxy
{
    /**
     * Proxy target
     *
     * @var string
     */
    protected string $proxyTarget = SuperglobalsManager::class;
}
