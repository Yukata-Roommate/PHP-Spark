<?php

namespace Spark\Concerns\Proxy;

/**
 * Proxyable
 *
 * @package Spark\Concerns\Proxy
 *
 * @property string $proxyTarget
 * @property array<string> $callableMethods
 * @property array<string> $uncallableMethods
 */
trait Proxyable
{
    /*----------------------------------------*
     * Call Method
     *----------------------------------------*/

    /**
     * call dynamic method
     *
     * @param string $method
     * @param array<mixed> $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters): mixed
    {
        return $this->_callMethod($method, $parameters);
    }

    /**
     * call statically method
     *
     * @param string $method
     * @param array<mixed> $parameters
     * @return mixed
     */
    public static function __callStatic(string $method, array $parameters): mixed
    {
        $instance = new static();

        return $instance->{$method}(...$parameters);
    }

    /**
     * call method
     *
     * @param string $method
     * @param array<mixed> $parameters
     * @return mixed
     */
    protected function _callMethod(string $method, array $parameters): mixed
    {
        if (!$this->_isCallableMethod($method)) throw new \Exception("method {$method} can not call");

        $instance = $this->_proxyTargetInstance($method, $parameters);

        return $instance->$method(...$parameters);
    }

    /*----------------------------------------*
     * Proxy Target
     *----------------------------------------*/

    /**
     * proxy target cache
     *
     * @var object|null
     */
    protected object|null $proxyTargetCache = null;

    /**
     * get proxy target
     *
     * @return string
     */
    protected function _proxyTarget(): string
    {
        if (!property_exists($this, "proxyTarget")) throw new \Exception("proxy target is not defined");

        if (!is_string($this->proxyTarget)) throw new \Exception("proxy target is not string");

        return $this->proxyTarget;
    }

    /**
     * get proxy target instance
     *
     * @param string $method
     * @param array<mixed> $parameters
     * @return object
     */
    protected function _proxyTargetInstance(string $method, array $parameters): object
    {
        if (!is_null($this->proxyTargetCache)) return $this->proxyTargetCache;

        $target = $this->_proxyTarget();

        if (!class_exists($target)) throw new \Exception("proxy target class {$target} does not exist");

        $instance = new $target();

        $this->proxyTargetCache = $instance;

        return $instance;
    }

    /*----------------------------------------*
     * Callable & UnCallable
     *----------------------------------------*/

    /**
     * whether method is callable
     *
     * @param string $method
     * @return bool
     */
    protected function _isCallableMethod(string $method): bool
    {
        $callableMethods = $this->_callableMethods();

        if (!empty($callableMethods) && !in_array($method, $callableMethods)) return false;

        $uncallableMethods = $this->_uncallableMethods();

        if (!empty($uncallableMethods) && in_array($method, $uncallableMethods)) return false;

        return true;
    }

    /**
     * get callable methods
     *
     * @return array<string>
     */
    protected function _callableMethods(): array
    {
        return property_exists($this, "callableMethods") ? $this->callableMethods : [];
    }

    /**
     * get uncallable methods
     *
     * @return array<string>
     */
    protected function _uncallableMethods(): array
    {
        return property_exists($this, "uncallableMethods") ? $this->uncallableMethods : [];
    }
}
