<?php

declare(strict_types=1);

namespace Spark\Contracts\File;

use Spark\Contracts\File\Writer;

/**
 * Text File Writer Contract
 *
 * @package Spark\Contracts\File
 */
interface TextWriter extends Writer
{
    /*----------------------------------------*
     * BOM
     *----------------------------------------*/

    /**
     * Set whether to add BOM
     *
     * @param bool $useBom
     * @return static
     */
    public function setUseBom(bool $useBom): static;

    /**
     * Check if using BOM
     *
     * @return bool
     */
    public function useBom(): bool;
}
