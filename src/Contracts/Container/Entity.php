<?php

declare(strict_types=1);

namespace Spark\Contracts\Container;

use Spark\Contracts\Container\DataAccessor;
use Spark\Contracts\Container\Checkable;
use Spark\Contracts\Container\Collectable;

/**
 * Container Entity Contract
 *
 * @package Spark\Contracts\Container
 */
interface Entity extends DataAccessor, Checkable, Collectable
{
    /**
     * Get internal data
     *
     * @return array<string, mixed>|object
     */
    public function data(): array|object;
}
