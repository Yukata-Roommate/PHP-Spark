<?php

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
     * signature
     *
     * @var string
     */
    protected string $signature = "list";

    /**
     * description
     *
     * @var string
     */
    protected string $description = "登録されているコマンド一覧を表示する";

    /*----------------------------------------*
     * Run
     *----------------------------------------*/

    /**
     * commands
     *
     * @var array<string, \Spark\Contracts\Console\Command>
     */
    protected array $commands = [];

    /**
     * constructor
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
     * execute
     *
     * @return void
     */
    protected function execute(): void
    {
        $this->line("Registered commands:");

        foreach ($this->commands as $command) {
            $this->line("\t{$command->signature()}\t{$command->description()}");
        }
    }
}
