<?php

declare(strict_types=1);

namespace Spark\Foundation\Container;

use Spark\Contracts\Container\Entity as EntityContract;

use Spark\Foundation\Container\DataAccessor;
use Spark\Concerns\Container\Accessible;
use Spark\Concerns\Container\Collectable;

/**
 * Container Entity
 *
 * @package Spark\Foundation\Container
 */
abstract class Entity extends DataAccessor implements EntityContract
{
    use Accessible;
    use Collectable;

    /**
     * Constructor
     *
     * @param array<string, mixed>|object|null $data
     */
    public function __construct(array|object|null $data = null)
    {
        $this->_data = $data ?? [];
    }

    /**
     * Internal data storage
     *
     * @var array<string, mixed>|object
     */
    protected array|object $_data;

    /**
     * {@inheritDoc}
     */
    public function data(): array|object
    {
        return $this->_data;
    }

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
        return $this->_data;
    }

    /*----------------------------------------*
     * Collectable
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        if (is_array($this->_data)) return $this->_data;

        return $this->getObjectProperties($this->_data);
    }
}
