<?php

declare(strict_types=1);

namespace Spark\Concerns\Container;

/**
 * Accessible
 *
 * @package Spark\Concerns\Container
 *
 * @method mixed dataSource()
 */
trait Accessible
{
    /**
     * Get property value
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function get(string $name, mixed $default = null): mixed
    {
        $source = $this->dataSource();

        if (is_array($source)) return $source[$name] ?? $default;

        if (is_object($source)) return $source->{$name} ?? $default;

        return $default;
    }

    /**
     * Check if property exists
     *
     * @param string $name
     * @return bool
     */
    public function isset(string $name): bool
    {
        $source = $this->dataSource();

        if (is_array($source)) return isset($source[$name]);

        if (is_object($source)) return isset($source->{$name});

        return false;
    }

    /**
     * Check if property exists
     *
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        $source = $this->dataSource();

        if (is_array($source)) return array_key_exists($name, $source);

        if (is_object($source)) return property_exists($source, $name);

        return false;
    }

    /**
     * Check if container is empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        $source = $this->dataSource();

        if (is_array($source)) return empty($source);

        if (is_object($source)) return empty(get_object_vars($source));

        return true;
    }
}
