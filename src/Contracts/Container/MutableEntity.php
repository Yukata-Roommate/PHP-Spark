<?php

declare(strict_types=1);

namespace Spark\Contracts\Container;

use Spark\Contracts\Container\Entity;
use Spark\Contracts\Container\Mutable;

/**
 * Container Mutable Entity Contract
 *
 * @package Spark\Contracts\Container
 */
interface MutableEntity extends Entity, Mutable
{
    /**
     * Set internal data
     *
     * @param array<string, mixed>|object $data
     * @return static
     */
    public function setData(array|object $data): static;

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
