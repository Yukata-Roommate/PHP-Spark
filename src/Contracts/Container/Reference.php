<?php

declare(strict_types=1);

namespace Spark\Contracts\Container;

use Spark\Contracts\Container\DataAccessor;
use Spark\Contracts\Container\Checkable;
use Spark\Contracts\Container\Collectable;

/**
 * Container Reference Contract
 *
 * @package Spark\Contracts\Container
 */
interface Reference extends DataAccessor, Checkable, Collectable {}
