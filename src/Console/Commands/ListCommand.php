<?php

declare(strict_types=1);

namespace Spark\Console\Commands;

use Spark\Foundation\Console\Command;

/**
 * List Command
 *
 * @package Spark\Console\Commands
 */
class ListCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected string $signature = "list";

    /**
     * {@inheritDoc}
     */
    protected string $description = "Show all registered commands";

    /*----------------------------------------*
     * Run
     *----------------------------------------*/

    /**
     * Commands
     *
     * @var array<string, \Spark\Contracts\Console\Command>
     */
    protected array $commands = [];

    /**
     * Constructor
     *
     * @param array<string, \Spark\Contracts\Console\Command> $commands
     */
    public function __construct(array $commands)
    {
        $this->commands = $commands;
    }

    /*----------------------------------------*
     * Run
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    protected function execute(): void
    {
        $this->line("Registered commands:");

        foreach ($this->commands as $command) {
            $this->line("\t{$command->signature()}\t{$command->description()}");
        }
    }
}
