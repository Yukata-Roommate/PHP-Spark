<?php

declare(strict_types=1);

namespace Spark\Contracts\File;

use Spark\Contracts\File\Reader;

/**
 * Text File Reader Contract
 *
 * @package Spark\Contracts\File
 */
interface TextReader extends Reader
{
    /*----------------------------------------*
     * Trim
     *----------------------------------------*/

    /**
     * Set whether to trim line endings
     *
     * @param bool $trimLineEndings
     * @return static
     */
    public function setTrimLineEndings(bool $trimLineEndings): static;

    /**
     * Check if trimming line endings
     *
     * @return bool
     */
    public function trimLineEndings(): bool;

    /*----------------------------------------*
     * Skip
     *----------------------------------------*/

    /**
     * Set whether to skip empty lines
     *
     * @param bool $skipEmpty
     * @return static
     */
    public function setSkipEmpty(bool $skipEmpty): static;

    /**
     * Check if skipping empty lines
     *
     * @return bool
     */
    public function skipEmpty(): bool;
}
