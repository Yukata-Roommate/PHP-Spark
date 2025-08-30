<?php

declare(strict_types=1);

namespace Spark\Exceptions\Proxy;

use Spark\Exceptions\Proxy\TargetException;

/**
 * Target Invalid Exception
 *
 * @package Spark\Exceptions\Proxy
 */
class TargetInvalidException extends TargetException
{
    /**
     * Invalid target value
     *
     * @var mixed
     */
    protected mixed $target;

    /**
     * Expected type
     *
     * @var string
     */
    protected string $expectedType;

    /**
     * Actual type
     *
     * @var string
     */
    protected string $actualType;

    /**
     * Constructor
     *
     * @param mixed $target
     * @param string $expectedType
     * @param string $actualType
     */
    public function __construct(mixed $target, string $expectedType, string $actualType)
    {
        $this->target       = $target;
        $this->expectedType = $expectedType;
        $this->actualType   = $actualType;

        parent::__construct("Proxy target must be {$expectedType}, {$actualType} given.");
    }

    /**
     * Get invalid target
     *
     * @return mixed
     */
    public function target(): mixed
    {
        return $this->target;
    }

    /**
     * Get expected type
     *
     * @return string
     */
    public function expectedType(): string
    {
        return $this->expectedType;
    }

    /**
     * Get actual type
     *
     * @return string
     */
    public function actualType(): string
    {
        return $this->actualType;
    }
}
