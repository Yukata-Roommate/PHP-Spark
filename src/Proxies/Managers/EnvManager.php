<?php

declare(strict_types=1);

namespace Spark\Proxies\Managers;

use Spark\Foundation\Proxy\SingletonManager;

use Spark\Supports\Env\Loader;

/**
 * Env Proxy Manager
 *
 * @package Spark\Proxies\Managers
 */
class EnvManager extends SingletonManager
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
        $this->addFactory(Loader::class, fn() => new Loader());
    }

    /*----------------------------------------*
     * Accessor
     *----------------------------------------*/

    /**
     * Get env loader
     *
     * @return \Spark\Supports\Env\Loader
     */
    public function loader(): Loader
    {
        return $this->singleton(Loader::class);
    }

    /*----------------------------------------*
     * Load
     *----------------------------------------*/

    /**
     * Loaded cache
     *
     * @var array<string, mixed>
     */
    protected array $loaded = [];

    /**
     * Flush loaded cache
     *
     * @return void
     */
    public function flush(): void
    {
        $this->loaded = [];
    }

    /**
     * Load property
     *
     * @param string $name
     * @param callable $loader
     * @return mixed
     */
    protected function load(string $name, callable $loader): mixed
    {
        if (array_key_exists($name, $this->loaded)) return $this->loaded[$name];

        $value = $loader();

        $this->loaded[$name] = $value;

        return $value;
    }

    /**
     * Get property as string
     *
     * @param string $name
     * @param string|null $default
     * @return string
     */
    public function string(string $name, string|null $default = null): string
    {
        return $this->load($name, fn() => $this->loader()->string($name, $default));
    }

    /**
     * Get property as nullable string
     *
     * @param string $name
     * @return string|null
     */
    public function nullableString(string $name): string|null
    {
        return $this->load($name, fn() => $this->loader()->nullableString($name));
    }

    /**
     * Get property as int
     *
     * @param string $name
     * @param int|null $default
     * @return int
     */
    public function int(string $name, int|null $default = null): int
    {
        return $this->load($name, fn() => $this->loader()->int($name, $default));
    }

    /**
     * Get property as nullable int
     *
     * @param string $name
     * @return int|null
     */
    public function nullableInt(string $name): int|null
    {
        return $this->load($name, fn() => $this->loader()->nullableInt($name));
    }

    /**
     * Get property as float
     *
     * @param string $name
     * @param float|null $default
     * @return float
     */
    public function float(string $name, float|null $default = null): float
    {
        return $this->load($name, fn() => $this->loader()->float($name, $default));
    }

    /**
     * Get property as nullable float
     *
     * @param string $name
     * @return float|null
     */
    public function nullableFloat(string $name): float|null
    {
        return $this->load($name, fn() => $this->loader()->nullableFloat($name));
    }

    /**
     * Get property as bool
     *
     * @param string $name
     * @param bool|null $default
     * @return bool
     */
    public function bool(string $name, bool|null $default = null): bool
    {
        return $this->load($name, fn() => $this->loader()->bool($name, $default));
    }

    /**
     * Get property as nullable bool
     *
     * @param string $name
     * @return bool|null
     */
    public function nullableBool(string $name): bool|null
    {
        return $this->load($name, fn() => $this->loader()->nullableBool($name));
    }

    /**
     * Get property as array
     *
     * @param string $name
     * @param array|null $default
     * @return array
     */
    public function array(string $name, array|null $default = null): array
    {
        return $this->load($name, fn() => $this->loader()->array($name, $default));
    }

    /**
     * Get property as nullable array
     *
     * @param string $name
     * @return array|null
     */
    public function nullableArray(string $name): array|null
    {
        return $this->load($name, fn() => $this->loader()->nullableArray($name));
    }

    /**
     * Get property as object
     *
     * @param string $name
     * @param object|null $default
     * @return object
     */
    public function object(string $name, object|null $default = null): object
    {
        return $this->load($name, fn() => $this->loader()->object($name, $default));
    }

    /**
     * Get property as nullable object
     *
     * @param string $name
     * @return object|null
     */
    public function nullableObject(string $name): object|null
    {
        return $this->load($name, fn() => $this->loader()->nullableObject($name));
    }

    /**
     * Get property as enum
     *
     * @param string $name
     * @param string $enumClass
     * @param \UnitEnum|null $default
     * @return \UnitEnum
     */
    public function enum(string $name, string $enumClass, \UnitEnum|null $default = null): \UnitEnum
    {
        return $this->load($name, fn() => $this->loader()->enum($name, $enumClass, $default));
    }

    /**
     * Get property as nullable enum
     *
     * @param string $name
     * @param string $enumClass
     * @return \UnitEnum|null
     */
    public function nullableEnum(string $name, string $enumClass): \UnitEnum|null
    {
        return $this->load($name, fn() => $this->loader()->nullableEnum($name, $enumClass));
    }
}
