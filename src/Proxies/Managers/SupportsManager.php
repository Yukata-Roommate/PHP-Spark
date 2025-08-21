<?php

namespace Spark\Proxies\Managers;

use Spark\Foundation\Proxy\SingletonManager;

use Spark\Proxies\Managers\Supports\GlobalManager;
use Spark\Proxies\Managers\Supports\EnvManager;

/**
 * Supports Proxy Manager
 *
 * @package Spark\Proxies\Managers
 */
class SupportsManager extends SingletonManager
{
    /*----------------------------------------*
     * Singleton
     *----------------------------------------*/

    /**
     * init singletons
     *
     * @return void
     */
    protected function initSingletons(): void
    {
        $this->addFactory(GlobalManager::class, fn() => new GlobalManager());
        $this->addFactory(EnvManager::class, fn() => new EnvManager());
    }

    /*----------------------------------------*
     * Accessor
     *----------------------------------------*/

    /**
     * get global manager
     *
     * @return \Spark\Proxies\Managers\Supports\GlobalManager
     */
    public function global(): GlobalManager
    {
        return $this->singleton(GlobalManager::class);
    }

    /**
     * get env manager
     *
     * @return \Spark\Proxies\Managers\Supports\EnvManager
     */
    public function env(): EnvManager
    {
        return $this->singleton(EnvManager::class);
    }
}
