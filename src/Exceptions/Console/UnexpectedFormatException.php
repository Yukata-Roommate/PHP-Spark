<?php

declare(strict_types=1);

namespace Spark\Exceptions\Console;

use Spark\Exceptions\Console\ArgumentException;

/**
 * Unexpected Format Exception
 *
 * @package Spark\Exceptions\Console
 */
class UnexpectedFormatException extends ArgumentException
{
    /**
     * Argument name or index
     *
     * @var string|int
     */
    protected string|int $argument;

    /**
     * Expected format
     *
     * @var string
     */
    protected string $expectedFormat;

    /**
     * Constructor
     *
     * @param string|int $argument
     * @param string $expectedFormat
     */
    public function __construct(string|int $argument, string $expectedFormat)
    {
        $this->argument       = $argument;
        $this->expectedFormat = $expectedFormat;

        parent::__construct("Argument {$argument} does not match expected format: {$expectedFormat}");
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
     * Get expected format
     *
     * @return string
     */
    public function expectedFormat(): string
    {
        return $this->expectedFormat;
    }
}
