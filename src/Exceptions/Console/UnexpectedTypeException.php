<?php

declare(strict_types=1);

namespace Spark\Exceptions\Console;

use Spark\Exceptions\Console\ArgumentException;

/**
 * Unexpected Type Exception
 *
 * @package Spark\Exceptions\Console
 */
class UnexpectedTypeException extends ArgumentException
{
    /**
     * Argument name or index
     *
     * @var string|int
     */
    protected string|int $argument;

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
     * @param string|int $argument
     * @param string $expectedType
     * @param string $actualType
     */
    public function __construct(string|int $argument, string $expectedType, string $actualType)
    {
        $this->argument     = $argument;
        $this->expectedType = $expectedType;
        $this->actualType   = $actualType;

        parent::__construct("Argument {$argument} must be {$expectedType}, {$actualType} given");
    }

    /**
     * Get argument name or index
     *
     * @return string|int
     */
    public function argument(): string|int
    {
        return $this->argument;
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
