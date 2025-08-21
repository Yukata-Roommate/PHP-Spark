<?php

namespace Spark\Foundation\Proxy;

use Spark\Foundation\Proxy\ProxyManager;

/**
 * Singleton Proxy Manager
 *
 * @package Spark\Foundation\Proxy
 */
abstract class SingletonManager extends ProxyManager
{
    /*----------------------------------------*
     * Initialization
     *----------------------------------------*/

    /**
     * init manager
     *
     * @return void
     */
    protected function init(): void
    {
        $this->initSingletons();
    }

    /*----------------------------------------*
     * Singleton
     *----------------------------------------*/

    /**
     * singleton instances
     *
     * @var array<string, object>
     */
    protected array $singletons = [];

    /**
     * singleton factories
     *
     * @var array<string, callable>
     */
    protected array $singletonFactories = [];

    /**
     * init singletons
     *
     * @return void
     */
    abstract protected function initSingletons(): void;

    /**
     * add singleton instance
     *
     * @param string $name
     * @param object $instance
     * @return void
     */
    protected function addSingleton(string $name, object $instance): void
    {
        $this->singletons[$name] = $instance;
    }

    /**
     * add singleton factory
     *
     * @param string $name
     * @param callable $factory
     * @return void
     */
    protected function addFactory(string $name, callable $factory): void
    {
        $this->singletonFactories[$name] = $factory;
    }

    /**
     * get singleton instance
     *
     * @param string $name
     * @return object
     */
    protected function singleton(string $name): object
    {
        if (isset($this->singletons[$name])) return $this->singletons[$name];

        if (!isset($this->singletonFactories[$name])) throw new \Exception("Singleton instance {$name} does not exist");

        $factory = $this->singletonFactories[$name];

        $instance = $factory();

        if (!is_object($instance)) throw new \Exception("Singleton factory {$name} must return an object");

        $this->singletons[$name] = $instance;

        return $instance;
    }
}
