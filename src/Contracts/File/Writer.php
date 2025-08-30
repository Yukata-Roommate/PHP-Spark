<?php

declare(strict_types=1);

namespace Spark\Contracts\File;

use Spark\Contracts\File\Operator;

/**
 * File Writer Contract
 *
 * @package Spark\Contracts\File
 */
interface Writer extends Operator
{
    /*----------------------------------------*
     * Write
     *----------------------------------------*/

    /**
     * Write content to file
     *
     * @param string $data
     * @return bool
     * @throws \Spark\Exceptions\File\WriteException
     */
    public function write(string $data): bool;

    /**
     * Write lines to file
     *
     * @param array<mixed> $lines
     * @return bool
     * @throws \Spark\Exceptions\File\WriteException
     */
    public function writeLines(array $lines): bool;

    /*----------------------------------------*
     * Append
     *----------------------------------------*/

    /**
     * Append content to file
     *
     * @param string $data
     * @return bool
     * @throws \Spark\Exceptions\File\WriteException
     */
    public function append(string $data): bool;

    /**
     * Append lines to file
     *
     * @param array<mixed> $lines
     * @return bool
     * @throws \Spark\Exceptions\File\WriteException
     */
    public function appendLines(array $lines): bool;

    /*----------------------------------------*
     * Lock Exclusive
     *----------------------------------------*/

    /**
     * Set whether to use LOCK_EX flag
     *
     * @param bool $lockEx
     * @return static
     */
    public function setLockEx(bool $lockEx = true): static;

    /**
     * Check if using LOCK_EX flag
     *
     * @return bool
     */
    public function lockEx(): bool;

    /*----------------------------------------*
     * New Line
     *----------------------------------------*/

    /**
     * Set new line character
     *
     * @param string $newLine
     * @return static
     */
    public function setNewLine(string $newLine): static;

    /**
     * Get new line character
     *
     * @return string
     */
    public function newLine(): string;

    /*----------------------------------------*
     * Encoding
     *----------------------------------------*/

    /**
     * Set file encoding
     *
     * @param string $encoding
     * @return static
     */
    public function setEncoding(string $encoding): static;

    /**
     * Get file encoding
     *
     * @return string
     */
    public function encoding(): string;
}
