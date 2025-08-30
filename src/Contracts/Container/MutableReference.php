<?php

declare(strict_types=1);

namespace Spark\Contracts\Container;

use Spark\Contracts\Container\Reference;
use Spark\Contracts\Container\Mutable;

/**
 * Container Mutable Reference Contract
 *
 * @package Spark\Contracts\Container
 */
interface MutableReference extends Reference, Mutable
{
    /**
     * Merge multiple values
     *
     * @param array<string, mixed>|object $values
     * @param bool $overwrite
     * @return static
     */
    public function merge(array|object $values, bool $overwrite = true): static;

    /**
     * Replace all values
     *
     * @param array<string, mixed>|object $values
     * @return static
     */
    public function replace(array|object $values): static;
}
