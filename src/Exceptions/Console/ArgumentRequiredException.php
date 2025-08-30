<?php

declare(strict_types=1);

namespace Spark\Exceptions\Console;

use Spark\Exceptions\Console\ArgumentException;

/**
 * Argument Required Exception
 *
 * @package Spark\Exceptions\Console
 */
class ArgumentRequiredException extends ArgumentException
{
    /**
     * Argument name or index
     *
     * @var string|int
     */
    protected string|int $argument;

    /**
     * Constructor
     *
     * @param string|int $argument
     */
    public function __construct(string|int $argument)
    {
        $this->argument = $argument;

        parent::__construct("Required argument {$argument} is missing");
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
}
