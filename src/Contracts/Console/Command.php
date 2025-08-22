<?php

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
     * get signature
     *
     * @return string
     */
    public function signature(): string;

    /**
     * get description
     *
     * @return string
     */
    public function description(): string;

    /*----------------------------------------*
     * Run
     *----------------------------------------*/

    /**
     * run command
     *
     * @param array $arguments
     * @return void
     */
    public function run(array $arguments): void;
}
