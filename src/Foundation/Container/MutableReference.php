<?php

declare(strict_types=1);

namespace Spark\Foundation\Container;

use Spark\Contracts\Container\MutableReference as MutableReferenceContract;

use Spark\Foundation\Container\Reference;
use Spark\Concerns\Container\Mergeable;

/**
 * Container Mutable Reference
 *
 * @package Spark\Foundation\Container
 */
abstract class MutableReference extends Reference implements MutableReferenceContract
{
    use Mergeable;

    /*----------------------------------------*
     * Mutable
     *----------------------------------------*/

    /**
     * Get mutable source
     *
     * @return array<string, mixed>|object
     */
    protected function &mutableSource(): mixed
    {
        return $this->reference();
    }
}
