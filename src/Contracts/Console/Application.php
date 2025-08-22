<?php

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
     * run command
     *
     * @return void
     */
    public function run(): void;

    /*----------------------------------------*
     * Command
     *----------------------------------------*/

    /**
     * add command
     *
     * @param \Spark\Contracts\Console\Command|string $command
     * @return static
     */
    public function add(Command|string $command): static;
}
