<?php

declare(strict_types=1);

namespace Spark\Contracts\Container;

/**
 * Container Checkable Contract
 *
 * @package Spark\Contracts\Container
 */
interface Checkable
{
    /**
     * Check if property exists
     *
     * @param string $name
     * @return bool
     */
    public function isset(string $name): bool;

    /**
     * Check if property exists
     *
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Check if container is empty
     *
     * @return bool
     */
    public function isEmpty(): bool;
}
