<?php

declare(strict_types=1);

namespace Spark\Contracts\File;

use Spark\Contracts\File\Reader;

/**
 * CSV File Reader Contract
 *
 * @package Spark\Contracts\File
 */
interface CsvReader extends Reader
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
     * Set whether file has header
     *
     * @param bool $hasHeader
     * @return static
     */
    public function setHasHeader(bool $hasHeader): static;

    /**
     * Check if file has header
     *
     * @return bool
     */
    public function hasHeader(): bool;

    /**
     * Get headers from CSV
     *
     * @return array<string>
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\ReadException
     */
    public function headers(): array;

    /**
     * Set headers manually
     *
     * @param array<string> $headers
     * @return static
     */
    public function setHeaders(array $headers): static;

    /*----------------------------------------*
     * Trim
     *----------------------------------------*/

    /**
     * Set whether to trim values
     *
     * @param bool $trimValues
     * @return static
     */
    public function setTrimValues(bool $trimValues): static;

    /**
     * Check if trimming values
     *
     * @return bool
     */
    public function trimValues(): bool;

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
