<?php

declare(strict_types=1);

namespace Spark\Foundation\Container;

use Spark\Contracts\Container\Reference as ReferenceContract;

use Spark\Foundation\Container\DataAccessor;
use Spark\Concerns\Container\Accessible;
use Spark\Concerns\Container\Collectable;

/**
 * Container Reference
 *
 * @package Spark\Foundation\Container
 */
abstract class Reference extends DataAccessor implements ReferenceContract
{
    use Accessible;
    use Collectable;

    /**
     * Get reference to data source
     *
     * @return array<string, mixed>|object
     */
    abstract protected function &reference(): array|object;

    /*----------------------------------------*
     * Accessible
     *----------------------------------------*/

    /**
     * Get data source
     *
     * @return array<string, mixed>|object
     */
    protected function dataSource(): mixed
    {
        return $this->reference();
    }

    /*----------------------------------------*
     * Collectable
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $reference = &$this->reference();

        if (is_array($reference)) return $reference;

        return $this->getObjectProperties($reference);
    }
}
