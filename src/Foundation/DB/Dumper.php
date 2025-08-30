<?php

declare(strict_types=1);

namespace Spark\Foundation\DB;

use Spark\Contracts\DB\Dumper as DumperContract;

/**
 * DB Dumper
 *
 * @package Spark\Foundation\DB
 */
abstract class Dumper implements DumperContract
{
    /*----------------------------------------*
     * Dump Database
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    abstract public function driver(): string;

    /**
     * Set dump command
     *
     * @return void
     */
    abstract protected function setCommand(): void;

    /**
     * {@inheritDoc}
     */
    public function dump(): bool
    {
        $this->setCommand();

        $this->createDumpFile();

        return $this->executeCommand();
    }

    /**
     * Execute dump command
     *
     * @return bool
     */
    protected function executeCommand(): bool
    {
        $command = $this->commandString();

        $command = $this->prepareExecuteCommand($command);

        $output = exec($command);

        $output = $this->passesExecuteCommand($output);

        return $output !== null;
    }

    /**
     * Prepare execute command
     *
     * @param string $command
     * @return string
     */
    protected function prepareExecuteCommand(string $command): string
    {
        return $command;
    }

    /**
     * Passes execute command
     *
     * @param string $output
     * @return string
     */
    protected function passesExecuteCommand(string $output): string
    {
        return $output;
    }

    /*----------------------------------------*
     * Dump Command
     *----------------------------------------*/

    /**
     * Dump commands
     *
     * @var array<string>
     */
    protected array $commands = [];

    /**
     * {@inheritDoc}
     */
    public function command(): array
    {
        return $this->commands;
    }

    /**
     * {@inheritDoc}
     */
    public function commandString(): string
    {
        return implode(" ", $this->commands);
    }

    /**
     * {@inheritDoc}
     */
    public function addCommand(string $command): static
    {
        $this->commands[] = $command;

        return $this;
    }

    /**
     * Add dump file path
     *
     * @return void
     */
    protected function addDumpFile(): void
    {
        $this->addCommand(">");
        $this->addCommand($this->dumpFile());
    }

    /**
     * Add driver name
     *
     * @return void
     */
    protected function addDriverName(): void
    {
        $this->addCommand($this->driver());
    }

    /*----------------------------------------*
     * Dump File
     *----------------------------------------*/

    /**
     * Dump file path
     *
     * @var string
     */
    protected string $dumpFile;

    /**
     * {@inheritDoc}
     */
    public function dumpFile(): string
    {
        return $this->dumpFile;
    }

    /**
     * {@inheritDoc}
     */
    public function setDumpFile(string $dumpFile): static
    {
        $this->dumpFile = $dumpFile;

        return $this;
    }

    /**
     * Create dump file
     *
     * @return void
     */
    protected function createDumpFile(): void
    {
        $dumpFile  = $this->dumpFile();
        $directory = dirname($dumpFile);

        if (!is_dir($directory)) mkdir($directory, 0755, true);

        if (file_exists($dumpFile)) unlink($dumpFile);

        touch($dumpFile);
    }
}
