<?php

declare(strict_types=1);

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
     * Get parsed arguments
     *
     * @return array<string|int, string|int>
     */
    public function arguments(): array;

    /**
     * Get script name
     *
     * @return string
     */
    public function script(): string;

    /**
     * Get command signature
     *
     * @return string
     */
    public function signature(): string;
}
