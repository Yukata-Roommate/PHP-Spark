<?php

declare(strict_types=1);

namespace Spark\Contracts\File;

use Spark\Contracts\File\Reader;

/**
 * JSON File Reader Contract
 *
 * @package Spark\Contracts\File
 */
interface JsonReader extends Reader
{
    /*----------------------------------------*
     * JSON
     *----------------------------------------*/

    /**
     * Set JSON decode flags
     *
     * @param int $flags
     * @return static
     */
    public function setFlags(int $flags): static;

    /**
     * Add JSON decode flag
     *
     * @param int $flag
     * @return static
     */
    public function addFlag(int $flag): static;

    /**
     * Remove JSON decode flag
     *
     * @param int $flag
     * @return static
     */
    public function removeFlag(int $flag): static;

    /**
     * Clear all JSON decode flags
     *
     * @return static
     */
    public function clearFlags(): static;

    /**
     * Get JSON decode flags
     *
     * @return int
     */
    public function flags(): int;

    /**
     * Set maximum depth for JSON decoding
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

    /**
     * Set whether to return associative arrays
     *
     * @param bool $assoc
     * @return static
     */
    public function setAssoc(bool $assoc): static;

    /**
     * Check if returning associative arrays
     *
     * @return bool
     */
    public function assoc(): bool;
}
