<?php

declare(strict_types=1);

namespace Spark\Foundation\Proxy;

use Spark\Foundation\Proxy\ProxyManager;

use Spark\Exceptions\Proxy\SingletonRegisteredException;
use Spark\Exceptions\Proxy\SingletonInvalidException;
use Spark\Exceptions\Proxy\SingletonNotFoundException;

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
     * Init manager
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
     * Stored singleton instances
     *
     * @var array<string, object>
     */
    protected array $singletons = [];

    /**
     * Factories for creating singleton instances
     *
     * @var array<string, callable>
     */
    protected array $singletonFactories = [];

    /**
     * Init singletons
     *
     * @return void
     * @throws \Spark\Exceptions\Proxy\SingletonRegisteredException
     */
    abstract protected function initSingletons(): void;

    /**
     * Register singleton instance
     *
     * @param string $name
     * @param object $instance
     * @return void
     */
    protected function addSingleton(string $name, object $instance): void
    {
        if (isset($this->singletons[$name])) throw new SingletonRegisteredException($name, "instance");

        if (isset($this->singletonFactories[$name])) throw new SingletonRegisteredException($name, "factory");

        $this->singletons[$name] = $instance;
    }

    /**
     * Register singleton factory
     *
     * @param string $name
     * @param callable $factory
     * @return void
     */
    protected function addFactory(string $name, callable $factory): void
    {
        if (isset($this->singletonFactories[$name])) throw new SingletonRegisteredException($name, "factory");

        if (isset($this->singletons[$name])) throw new SingletonRegisteredException($name, "instance");

        $this->singletonFactories[$name] = $factory;
    }

    /**
     * Get singleton instance
     *
     * @param string $name
     * @return object
     */
    protected function singleton(string $name): object
    {
        if (isset($this->singletons[$name])) return $this->singletons[$name];

        if (isset($this->singletonFactories[$name])) return $this->createFromFactory($name);

        throw new SingletonNotFoundException($name);
    }

    /**
     * Create singleton instance from factory
     *
     * @param string $name
     * @return object
     * @throws \Spark\Exceptions\Proxy\SingletonInvalidException
     */
    protected function createFromFactory(string $name): object
    {
        $factory = $this->singletonFactories[$name];

        $instance = $factory();

        if (!is_object($instance)) throw new SingletonInvalidException($name, "object", gettype($instance), $instance);

        $this->singletons[$name] = $instance;

        return $instance;
    }
}
