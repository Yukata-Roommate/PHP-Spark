<?php

declare(strict_types=1);

namespace Spark\Contracts\DB;

/**
 * DB Dumper Contract
 *
 * @package Spark\Contracts\DB
 */
interface Dumper
{
    /*----------------------------------------*
     * Dump Database
     *----------------------------------------*/

    /**
     * Get driver name
     *
     * @return string
     */
    public function driver(): string;

    /**
     * Dump database
     *
     * @return bool
     */
    public function dump(): bool;

    /*----------------------------------------*
     * Dump Command
     *----------------------------------------*/

    /**
     * Get dump command
     *
     * @return array<string>
     */
    public function command(): array;

    /**
     * Get dump command string
     *
     * @return string
     */
    public function commandString(): string;

    /**
     * Add dump command
     *
     * @param string $command
     * @return static
     */
    public function addCommand(string $command): static;

    /*----------------------------------------*
     * Dump File
     *----------------------------------------*/

    /**
     * Get dump file path
     *
     * @return string
     */
    public function dumpFile(): string;

    /**
     * Set dump file path
     *
     * @param string $dumpFile
     * @return static
     */
    public function setDumpFile(string $dumpFile): static;
}
