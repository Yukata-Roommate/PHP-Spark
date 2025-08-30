<?php

declare(strict_types=1);

namespace Spark\Contracts\Console;

use Spark\Contracts\Console\Command;

/**
 * Console Application Contract
 *
 * @package Spark\Contracts\Console
 */
interface Application
{
    /*----------------------------------------*
     * Run
     *----------------------------------------*/

    /**
     * Run application
     *
     * @return void
     * @throws \Spark\Exceptions\Console\CommandNotFoundException
     * @throws \Spark\Exceptions\Console\ClassNotFoundException
     * @throws \Spark\Exceptions\Console\InvalidCommandException
     * @throws \Spark\Exceptions\Console\SignatureException
     * @throws \Spark\Exceptions\Console\NoArgumentsException
     * @throws \Spark\Exceptions\Console\MalformedArgumentException
     * @throws \Spark\Exceptions\Console\EmptyOptionException
     * @throws \Spark\Exceptions\Console\OptionValueException
     * @throws \Spark\Exceptions\Console\ArgumentRequiredException
     * @throws \Spark\Exceptions\Console\UnexpectedTypeException
     * @throws \Spark\Exceptions\Console\UnexpectedFormatException
     * @throws \Spark\Exceptions\Console\ValidationException
     */
    public function run(): void;

    /*----------------------------------------*
     * Command
     *----------------------------------------*/

    /**
     * Add command to application
     *
     * @param \Spark\Contracts\Console\Command|class-string<\Spark\Contracts\Console\Command> $command
     * @return static
     * @throws \Spark\Exceptions\Console\ClassNotFoundException
     * @throws \Spark\Exceptions\Console\InvalidCommandException
     * @throws \Spark\Exceptions\Console\SignatureException
     */
    public function add(Command|string $command): static;

    /**
     * Get all registered commands
     *
     * @return array<string, \Spark\Contracts\Console\Command>
     */
    public function commands(): array;
}
