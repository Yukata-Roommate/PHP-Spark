<?php

namespace Spark\Proxies;

use Spark\Foundation\Proxy\MethodProxy;

use Spark\Proxies\Managers\ConsoleManager;

/**
 * Console Proxy
 *
 * @package Spark\Proxies
 *
 * @method static \Spark\Contracts\Console\Application application()
 *
 * @method static void run(\Spark\Contracts\Console\Command|string $command, array<string|int, string|int> $argv)
 *
 * @see \Spark\Proxies\Managers\ConsoleManager
 */
class Console extends MethodProxy
{
    /**
     * proxy target
     *
     * @var string
     */
    protected string $proxyTarget = ConsoleManager::class;
}
