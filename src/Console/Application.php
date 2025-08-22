<?php

namespace Spark\Console;

use Spark\Contracts\Console\Application as ApplicationContract;

use Spark\Contracts\Console\Command;

use Spark\Contracts\Console\ArgvInput as ArgvInputContract;
use Spark\Console\ArgvInput;

use Spark\Console\Commands\ListCommand;
use Spark\Console\Commands\TreeCommand;

/**
 * Application
 *
 * @package Spark\Console
 */
class Application implements ApplicationContract
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * constructor
     */
    public function __construct()
    {
        $this->add(new TreeCommand());
    }

    /*----------------------------------------*
     * Run
     *----------------------------------------*/

    /**
     * run command
     *
     * @return void
     */
    public function run(): void
    {
        $input = $this->input();

        $command = $this->resolveCommand($input);

        $command->run($input->arguments());
    }

    /*----------------------------------------*
     * Input
     *----------------------------------------*/

    /**
     * get argv input
     *
     * @return \Spark\Contracts\Console\ArgvInput
     */
    protected function input(): ArgvInputContract
    {
        return new ArgvInput();
    }

    /*----------------------------------------*
     * Command
     *----------------------------------------*/

    /**
     * command list
     *
     * @var array<string, \Spark\Contracts\Console\Command>
     */
    protected array $commands = [];

    /**
     * add command
     *
     * @param \Spark\Contracts\Console\Command|string $command
     * @return static
     */
    public function add(Command|string $command): static
    {
        if (is_string($command)) $command = new $command();

        if (!$command instanceof Command) throw new \InvalidArgumentException("Command must be an instance of Command");

        $this->commands[$command->signature()] = $command;

        return $this;
    }

    /**
     * resolve command
     *
     * @param \Spark\Contracts\Console\ArgvInput $input
     * @return \Spark\Contracts\Console\Command
     */
    protected function resolveCommand(ArgvInputContract $input): Command
    {
        $this->add(new ListCommand($this->commands));

        $signature = $input->signature();

        if (isset($this->commands[$signature])) return $this->commands[$signature];

        throw new \InvalidArgumentException("Command not found: {$signature}");
    }
}
