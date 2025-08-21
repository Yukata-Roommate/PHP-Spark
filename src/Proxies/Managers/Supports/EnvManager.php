<?php

namespace Spark\Proxies\Managers\Supports;

use Spark\Foundation\Proxy\SingletonManager;

use Spark\Supports\Env\Loader;

/**
 * Supports Env Proxy Manager
 *
 * @package Spark\Proxies\Managers\Supports
 */
class EnvManager extends SingletonManager
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
        $this->addFactory(Loader::class, fn() => new Loader());
    }

    /*----------------------------------------*
     * Accessor
     *----------------------------------------*/

    /**
     * get env loader
     *
     * @return \Spark\Supports\Env\Loader
     */
    public function loader(): Loader
    {
        return $this->singleton(Loader::class);
    }
}
