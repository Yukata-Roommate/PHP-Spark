<?php

declare(strict_types=1);

namespace Spark\Concerns\Proxy;

use Spark\Exceptions\Proxy\MethodNotCallableException;
use Spark\Exceptions\Proxy\MethodNotFoundException;
use Spark\Exceptions\Proxy\TargetInvalidException;
use Spark\Exceptions\Proxy\TargetNotDefinedException;
use Spark\Exceptions\Proxy\TargetNotFoundException;

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
     * Call
     *----------------------------------------*/

    /**
     * Handle dynamic method calls
     *
     * @param string $method
     * @param array<mixed> $parameters
     * @return mixed
     * @throws \Spark\Exceptions\Proxy\MethodNotCallableException
     * @throws \Spark\Exceptions\Proxy\MethodNotFoundException
     * @throws \Spark\Exceptions\Proxy\TargetInvalidException
     * @throws \Spark\Exceptions\Proxy\TargetNotDefinedException
     * @throws \Spark\Exceptions\Proxy\TargetNotFoundException
     */
    public function __call(string $method, array $parameters): mixed
    {
        return $this->callProxyMethod($method, $parameters);
    }

    /**
     * Handle static method calls
     *
     * @param string $method
     * @param array<mixed> $parameters
     * @return mixed
     * @throws \Spark\Exceptions\Proxy\MethodNotCallableException
     * @throws \Spark\Exceptions\Proxy\MethodNotFoundException
     * @throws \Spark\Exceptions\Proxy\TargetInvalidException
     * @throws \Spark\Exceptions\Proxy\TargetNotDefinedException
     * @throws \Spark\Exceptions\Proxy\TargetNotFoundException
     */
    public static function __callStatic(string $method, array $parameters): mixed
    {
        $instance = new static();

        return $instance->__call($method, $parameters);
    }

    /**
     * Call method on proxy target
     *
     * @param string $method
     * @param array<mixed> $parameters
     * @return mixed
     * @throws \Spark\Exceptions\Proxy\MethodNotCallableException
     * @throws \Spark\Exceptions\Proxy\MethodNotFoundException
     * @throws \Spark\Exceptions\Proxy\TargetInvalidException
     * @throws \Spark\Exceptions\Proxy\TargetNotDefinedException
     * @throws \Spark\Exceptions\Proxy\TargetNotFoundException
     */
    protected function callProxyMethod(string $method, array $parameters): mixed
    {
        $this->validateMethodCallable($method);

        $instance = $this->getProxyTargetInstance();

        if (!method_exists($instance, $method)) throw new MethodNotFoundException(get_class($instance), $method);

        return $instance->$method(...$parameters);
    }

    /*----------------------------------------*
     * Proxy Target
     *----------------------------------------*/

    /**
     * Cache for proxy target instance
     *
     * @var object|null
     */
    protected object|null $proxyTargetCache = null;

    /**
     * Get or create proxy target instance
     *
     * @return object
     * @throws \Spark\Exceptions\Proxy\TargetNotFoundException
     * @throws \Spark\Exceptions\Proxy\TargetNotDefinedException
     * @throws \Spark\Exceptions\Proxy\TargetInvalidException
     */
    protected function getProxyTargetInstance(): object
    {
        if ($this->proxyTargetCache !== null) return $this->proxyTargetCache;

        $targetClass = $this->getProxyTarget();

        if (!class_exists($targetClass)) throw new TargetNotFoundException($targetClass);

        $this->proxyTargetCache = $this->createProxyTargetInstance($targetClass);

        return $this->proxyTargetCache;
    }

    /**
     * Get proxy target class name
     *
     * @return string
     * @throws \Spark\Exceptions\Proxy\TargetNotDefinedException
     * @throws \Spark\Exceptions\Proxy\TargetInvalidException
     */
    protected function getProxyTarget(): string
    {
        if (!property_exists($this, "proxyTarget")) throw new TargetNotDefinedException(static::class);

        if (!is_string($this->proxyTarget)) throw new TargetInvalidException($this->proxyTarget, "string", gettype($this->proxyTarget));

        if (empty($this->proxyTarget)) throw new TargetNotDefinedException(static::class);

        return $this->proxyTarget;
    }

    /**
     * Create new instance of proxy target
     *
     * @param string $targetClass
     * @return object
     */
    protected function createProxyTargetInstance(string $targetClass): object
    {
        return new $targetClass();
    }

    /*----------------------------------------*
     * Validate
     *----------------------------------------*/

    /**
     * Validate if method can be called through proxy
     *
     * @param string $method
     * @return void
     * @throws \Spark\Exceptions\Proxy\MethodNotCallableException
     */
    protected function validateMethodCallable(string $method): void
    {
        if ($this->isMethodCallable($method)) return;

        $reason = $this->getMethodNotCallableReason($method);

        throw new MethodNotCallableException(static::class, $method, $reason);
    }

    /**
     * Check if method can be called through proxy
     *
     * @param string $method
     * @return bool
     */
    protected function isMethodCallable(string $method): bool
    {
        $callableMethods = $this->getCallableMethods();

        if (!empty($callableMethods) && !in_array($method, $callableMethods, true)) return false;

        $uncallableMethods = $this->getUncallableMethods();

        if (!empty($uncallableMethods) && in_array($method, $uncallableMethods, true)) return false;

        return true;
    }

    /**
     * Get list of methods can be called through proxy
     *
     * @return array<int, string>
     */
    protected function getCallableMethods(): array
    {
        return property_exists($this, "callableMethods") ? $this->callableMethods : [];
    }

    /**
     * Get list of methods cannot be called through proxy
     *
     * @return array<int, string>
     */
    protected function getUncallableMethods(): array
    {
        return property_exists($this, "uncallableMethods") ? $this->uncallableMethods : [];
    }

    /**
     * Get reason why method is not callable
     *
     * @param string $method
     * @return string
     */
    protected function getMethodNotCallableReason(string $method): string
    {
        $callableMethods = $this->getCallableMethods();

        if (!empty($callableMethods) && !in_array($method, $callableMethods, true)) return "not in whitelist";

        $uncallableMethods = $this->getUncallableMethods();

        if (!empty($uncallableMethods) && in_array($method, $uncallableMethods, true)) return "in blacklist";

        return "unknown reason";
    }
}
