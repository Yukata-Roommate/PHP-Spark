<?php

namespace Spark\Contracts\Console;

/**
 * Console ArgvInput Contract
 *
 * @package Spark\Contracts\Console
 */
interface ArgvInput
{
    /*----------------------------------------*
     * Argument
     *----------------------------------------*/

    /**
     * get arguments
     *
     * @return array<string|int, string|int>
     */
    public function arguments(): array;

    /**
     * get script
     *
     * @return string
     */
    public function script(): string;

    /**
     * get command signature
     *
     * @return string
     */
    public function signature(): string;
}
