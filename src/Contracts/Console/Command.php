<?php

declare(strict_types=1);

namespace Spark\Contracts\Console;

/**
 * Console Command Contract
 *
 * @package Spark\Contracts\Console
 */
interface Command
{
    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * Get command signature
     *
     * @return string
     */
    public function signature(): string;

    /**
     * Get command description
     *
     * @return string
     */
    public function description(): string;

    /*----------------------------------------*
     * Run
     *----------------------------------------*/

    /**
     * Run command
     *
     * @param array<string|int, string|int> $arguments
     * @return void
     * @throws \Spark\Exceptions\Console\ArgumentRequiredException
     * @throws \Spark\Exceptions\Console\UnexpectedTypeException
     * @throws \Spark\Exceptions\Console\UnexpectedFormatException
     * @throws \Spark\Exceptions\Console\ValidationException
     */
    public function run(array $arguments): void;
}
