<?php

declare(strict_types=1);

namespace Spark\Proxies;

use Spark\Foundation\Proxy\MethodProxy;

use Spark\Proxies\Managers\MonitorManager;

/**
 * Monitor Proxy
 *
 * @package Spark\Proxies
 *
 * @method static \Spark\Contracts\Monitor\PHPMonitor php()
 * @method static \Spark\Contracts\Monitor\SystemMonitor system()
 *
 * @see \Spark\Proxies\Managers\MonitorManager
 */
class Monitor extends MethodProxy
{
    /**
     * Proxy target
     *
     * @var string
     */
    protected string $proxyTarget = MonitorManager::class;
}
