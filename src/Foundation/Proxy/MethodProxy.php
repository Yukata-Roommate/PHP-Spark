<?php

declare(strict_types=1);

namespace Spark\Foundation\Proxy;

use Spark\Concerns\Proxy\Proxyable;

/**
 * Method Proxy
 *
 * @package Spark\Foundation\Proxy
 */
abstract class MethodProxy
{
    use Proxyable;

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * Proxy target
     *
     * @var string
     */
    protected string $proxyTarget;

    /**
     * Callable methods
     *
     * @var array<string>
     */
    protected array $callableMethods = [];

    /**
     * Uncallable methods
     *
     * @var array<string>
     */
    protected array $uncallableMethods = [];
}
