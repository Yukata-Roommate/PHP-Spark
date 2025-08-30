<?php

declare(strict_types=1);

namespace Spark\Exceptions\Container;

use Spark\Exceptions\Container\ValidationException;

/**
 * Unexpected Type Exception
 *
 * @package Spark\Exceptions\Container
 */
class UnexpectedTypeException extends ValidationException
{
    /**
     * Property name failed validation
     *
     * @var string
     */
    protected string $propertyName;

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
     * @param string $propertyName
     * @param string $expectedType
     * @param string $actualType
     */
    public function __construct(string $propertyName, string $expectedType, string $actualType)
    {
        $this->propertyName = $propertyName;
        $this->expectedType = $expectedType;
        $this->actualType   = $actualType;

        parent::__construct("Unexpected type for property \"{$propertyName}\". Expected {$expectedType}, got {$actualType}.");
    }

    /**
     * Get property name
     *
     * @return string
     */
    public function propertyName(): string
    {
        return $this->propertyName;
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
