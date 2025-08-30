<?php

declare(strict_types=1);

namespace Spark\Console;

use Spark\Contracts\Console\Application as ApplicationContract;

use Spark\Contracts\Console\Command;
use Spark\Contracts\Console\ArgvInput as ArgvInputContract;
use Spark\Console\ArgvInput;

use Spark\Console\Commands\ListCommand;
use Spark\Console\Commands\TreeCommand;

use Spark\Exceptions\Console\ClassNotFoundException;
use Spark\Exceptions\Console\InvalidCommandException;
use Spark\Exceptions\Console\SignatureException;
use Spark\Exceptions\Console\CommandNotFoundException;

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
     * Constructor
     */
    public function __construct()
    {
        $this->registerDefaultCommands();
    }

    /**
     * Register default commands
     *
     * @return void
     */
    protected function registerDefaultCommands(): void
    {
        $this->add(new TreeCommand());
    }

    /*----------------------------------------*
     * Run
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function run(): void
    {
        try {
            $input = $this->input();

            $command = $this->resolveCommand($input);

            $command->run($input->arguments());
        } catch (\Exception $exception) {
            $this->handleException($exception);

            throw $exception;
        }
    }

    /**
     * Handle exceptions during command execution
     *
     * @param \Exception $exception
     * @return void
     */
    protected function handleException(\Exception $exception): void {}

    /*----------------------------------------*
     * Input
     *----------------------------------------*/

    /**
     * Get argv input
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
     * Registered commands indexed by signature
     *
     * @var array<string, \Spark\Contracts\Console\Command>
     */
    protected array $commands = [];

    /**
     * {@inheritDoc}
     */
    public function add(Command|string $command): static
    {
        if (is_string($command)) {
            if (!class_exists($command)) throw new ClassNotFoundException($command);

            $command = new $command();
        }

        if (!$command instanceof Command) throw new InvalidCommandException(get_class($command));

        $signature = $command->signature();

        if (empty($signature)) throw new SignatureException(get_class($command));

        $this->commands[$signature] = $command;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function commands(): array
    {
        return $this->commands;
    }

    /**
     * Resolve command from input
     *
     * @param \Spark\Contracts\Console\ArgvInput $input
     * @return \Spark\Contracts\Console\Command
     * @throws \Spark\Exceptions\Console\CommandNotFoundException
     */
    protected function resolveCommand(ArgvInputContract $input): Command
    {
        $this->add(new ListCommand($this->commands));

        $signature = $input->signature();

        if (empty($signature)) throw new CommandNotFoundException($signature);

        if (!isset($this->commands[$signature])) throw new CommandNotFoundException($signature);

        return $this->commands[$signature];
    }
}
