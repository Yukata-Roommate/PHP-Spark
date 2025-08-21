<?php

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
     * proxy target
     *
     * @var string
     */
    protected string $proxyTarget;

    /**
     * callable methods
     *
     * @var array<string>
     */
    protected array $callableMethods = [];

    /**
     * uncallable methods
     *
     * @var array<string>
     */
    protected array $uncallableMethods = [];
}
