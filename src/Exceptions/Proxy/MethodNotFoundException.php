<?php

declare(strict_types=1);

namespace Spark\Exceptions\Proxy;

use Spark\Exceptions\Proxy\MethodException;

/**
 * Method Not Found Exception
 *
 * @package Spark\Exceptions\Proxy
 */
class MethodNotFoundException extends MethodException
{
    /**
     * Target class name
     *
     * @var string
     */
    protected string $className;

    /**
     * Method name
     *
     * @var string
     */
    protected string $method;

    /**
     * Constructor
     *
     * @param string $className
     * @param string $method
     */
    public function __construct(string $className, string $method)
    {
        $this->className = $className;
        $this->method    = $method;

        parent::__construct("Method \"{$method}\" does not exist on proxy target class \"{$className}\".");
    }

    /**
     * Get target class name
     *
     * @return string
     */
    public function className(): string
    {
        return $this->className;
    }

    /**
     * Get method name
     *
     * @return string
     */
    public function method(): string
    {
        return $this->method;
    }
}
