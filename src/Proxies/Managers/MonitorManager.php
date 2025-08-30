<?php

declare(strict_types=1);

namespace Spark\Proxies\Managers;

use Spark\Foundation\Proxy\SingletonManager;

use Spark\Contracts\Monitor\PHPMonitor as PHPMonitorContract;
use Spark\Monitor\PHPMonitor;

use Spark\Contracts\Monitor\SystemMonitor as SystemMonitorContract;
use Spark\Monitor\SystemMonitor;

/**
 * Monitor Proxy Manager
 *
 * @package Spark\Proxies\Managers
 */
class MonitorManager extends SingletonManager
{
    /*----------------------------------------*
     * Singleton
     *----------------------------------------*/

    /**
     * Init singletons
     *
     * @return void
     */
    protected function initSingletons(): void
    {
        $this->addFactory(PHPMonitorContract::class, fn() => new PHPMonitor());
        $this->addFactory(SystemMonitorContract::class, fn() => new SystemMonitor());
    }

    /*----------------------------------------*
     * Make
     *----------------------------------------*/

    /**
     * Make php monitor
     *
     * @return \Spark\Contracts\Monitor\PHPMonitor
     */
    public function php(): PHPMonitorContract
    {
        return $this->singleton(PHPMonitorContract::class);
    }

    /**
     * Make system monitor
     *
     * @return \Spark\Contracts\Monitor\SystemMonitor
     */
    public function system(): SystemMonitorContract
    {
        return $this->singleton(SystemMonitorContract::class);
    }
}
