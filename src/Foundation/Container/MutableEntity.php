<?php

declare(strict_types=1);

namespace Spark\Foundation\Container;

use Spark\Contracts\Container\MutableEntity as MutableEntityContract;

use Spark\Foundation\Container\Entity;
use Spark\Concerns\Container\Mergeable;

/**
 * Container Mutable Entity
 *
 * @package Spark\Foundation\Container
 */
abstract class MutableEntity extends Entity implements MutableEntityContract
{
    use Mergeable;

    /**
     * {@inheritDoc}
     */
    public function setData(array|object $data): static
    {
        $this->_data = $data;

        return $this;
    }

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
        return $this->_data;
    }
}
