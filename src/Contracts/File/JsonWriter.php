<?php

declare(strict_types=1);

namespace Spark\Contracts\File;

use Spark\Contracts\File\Writer;

/**
 * JSON File Writer Contract
 *
 * @package Spark\Contracts\File
 */
interface JsonWriter extends Writer
{
    /*----------------------------------------*
     * JSON
     *----------------------------------------*/

    /**
     * Set JSON encode flags
     *
     * @param int $flags
     * @return static
     */
    public function setFlags(int $flags): static;

    /**
     * Add JSON encode flag
     *
     * @param int $flag
     * @return static
     */
    public function addFlag(int $flag): static;

    /**
     * Remove JSON encode flag
     *
     * @param int $flag
     * @return static
     */
    public function removeFlag(int $flag): static;

    /**
     * Clear all JSON encode flags
     *
     * @return static
     */
    public function clearFlags(): static;

    /**
     * Get JSON encode flags
     *
     * @return int
     */
    public function flags(): int;

    /**
     * Set maximum depth for JSON encoding
     *
     * @param int $depth
     * @return static
     */
    public function setDepth(int $depth): static;

    /**
     * Get maximum depth
     *
     * @return int
     */
    public function depth(): int;
}
