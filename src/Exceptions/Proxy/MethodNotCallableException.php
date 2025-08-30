<?php

declare(strict_types=1);

namespace Spark\Exceptions\Proxy;

use Spark\Exceptions\Proxy\MethodException;

/**
 * Method Not Callable Exception
 *
 * @package Spark\Exceptions\Proxy
 */
class MethodNotCallableException extends MethodException
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
     * Reason why method is not callable
     *
     * @var string
     */
    protected string $reason;

    /**
     * Constructor
     *
     * @param string $className
     * @param string $method
     * @param string $reason
     */
    public function __construct(string $className, string $method, string $reason)
    {
        $this->className = $className;
        $this->method    = $method;
        $this->reason    = $reason;

        parent::__construct("Method \"{$method}\" is not callable on \"{$className}\" through proxy: {$reason}");
    }

    /**
     * Get class name
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

    /**
     * Get reason
     *
     * @return string
     */
    public function reason(): string
    {
        return $this->reason;
    }
}
