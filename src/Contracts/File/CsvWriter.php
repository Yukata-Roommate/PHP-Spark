<?php

declare(strict_types=1);

namespace Spark\Contracts\File;

use Spark\Contracts\File\Writer;

/**
 * CSV File Writer Contract
 *
 * @package Spark\Contracts\File
 */
interface CsvWriter extends Writer
{
    /*----------------------------------------*
     * Control
     *----------------------------------------*/

    /**
     * Set CSV delimiter
     *
     * @param string $delimiter
     * @return static
     */
    public function setDelimiter(string $delimiter): static;

    /**
     * Get CSV delimiter
     *
     * @return string
     */
    public function delimiter(): string;

    /**
     * Set CSV enclosure
     *
     * @param string $enclosure
     * @return static
     */
    public function setEnclosure(string $enclosure): static;

    /**
     * Get CSV enclosure
     *
     * @return string
     */
    public function enclosure(): string;

    /**
     * Set CSV escape character
     *
     * @param string $escape
     * @return static
     */
    public function setEscape(string $escape): static;

    /**
     * Get CSV escape character
     *
     * @return string
     */
    public function escape(): string;

    /*----------------------------------------*
     * Header
     *----------------------------------------*/

    /**
     * Set whether to write header
     *
     * @param bool $hasHeader
     * @return static
     */
    public function setHasHeader(bool $hasHeader): static;

    /**
     * Check if writing header
     *
     * @return bool
     */
    public function hasHeader(): bool;

    /**
     * Set headers for CSV
     *
     * @param array<string> $headers
     * @return static
     */
    public function setHeaders(array $headers): static;

    /**
     * Get headers
     *
     * @return array<string>
     */
    public function headers(): array;

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

    /*----------------------------------------*
     * Sanitize
     *----------------------------------------*/

    /**
     * Set whether to sanitize values for CSV injection
     *
     * @param bool $sanitize
     * @return static
     */
    public function setSanitize(bool $sanitize): static;

    /**
     * Check if sanitizing values
     *
     * @return bool
     */
    public function sanitize(): bool;
}
