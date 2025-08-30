<?php

declare(strict_types=1);

namespace Spark\Contracts\Container;

/**
 * Container Mutable Contract
 *
 * @package Spark\Contracts\Container
 */
interface Mutable
{
    /**
     * Set property value
     *
     * @param string $name
     * @param mixed $value
     * @return static
     */
    public function set(string $name, mixed $value): static;

    /**
     * Add property value
     *
     * @param string $name
     * @param mixed $value
     * @return static
     */
    public function add(string $name, mixed $value): static;

    /**
     * Remove property
     *
     * @param string $name
     * @return static
     */
    public function remove(string $name): static;

    /**
     * Delete property
     *
     * @param string $name
     * @return static
     */
    public function delete(string $name): static;

    /**
     * Unset property
     *
     * @param string $name
     * @return static
     */
    public function unset(string $name): static;

    /**
     * Clear all values
     *
     * @return static
     */
    public function clear(): static;

    /**
     * Flush all data
     *
     * @return static
     */
    public function flush(): static;
}
