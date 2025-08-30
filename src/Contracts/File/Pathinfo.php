<?php

declare(strict_types=1);

namespace Spark\Contracts\File;

/**
 * File Pathinfo Contract
 *
 * @package Spark\Contracts\File
 */
interface Pathinfo
{
    /*----------------------------------------*
     * Path
     *----------------------------------------*/

    /**
     * Set file path
     *
     * @param string $path
     * @return static
     */
    public function setPath(string $path): static;

    /**
     * Check if path is set
     *
     * @return bool
     */
    public function issetPath(): bool;

    /**
     * Get file path
     *
     * @return string
     */
    public function path(): string;

    /**
     * Get real path
     *
     * @return string|null
     */
    public function realpath(): string|null;

    /*----------------------------------------*
     * Info
     *----------------------------------------*/

    /**
     * Get path info
     *
     * @return array<string, string|null>
     */
    public function pathInfo(): array;

    /**
     * Get directory name
     *
     * @return string
     */
    public function dirname(): string;

    /**
     * Get file name with extension
     *
     * @return string
     */
    public function basename(): string;

    /**
     * Get file extension
     *
     * @return string|null
     */
    public function extension(): string|null;

    /**
     * Get file name without extension
     *
     * @return string
     */
    public function filename(): string;

    /*----------------------------------------*
     * Mime
     *----------------------------------------*/

    /**
     * Get mime type
     *
     * @return string|null
     * @throws \Spark\Exceptions\File\NotFoundException
     */
    public function mimetype(): string|null;

    /*----------------------------------------*
     * Last Modified
     *----------------------------------------*/

    /**
     * Get last modified time
     *
     * @return int|null
     */
    public function lastModified(): int|null;

    /**
     * Get last modified time as DateTime
     *
     * @return \DateTimeInterface|null
     */
    public function lastModifiedDateTime(): \DateTimeInterface|null;

    /*----------------------------------------*
     * Size
     *----------------------------------------*/

    /**
     * Get file size in bytes
     *
     * @return int|null
     */
    public function size(): int|null;

    /**
     * Get formatted file size with appropriate unit
     *
     * @param int $precision
     * @return string|null
     */
    public function formattedSize(int $precision = 2): string|null;

    /*----------------------------------------*
     * Permission
     *----------------------------------------*/

    /**
     * Get file permissions as octal string
     *
     * @return string|null
     */
    public function permissions(): string|null;

    /**
     * Get file owner information
     *
     * @return array<string, int|string>|null
     */
    public function owner(): array|null;

    /**
     * Get file group information
     *
     * @return array<string, int|string>|null
     */
    public function group(): array|null;

    /*----------------------------------------*
     * Check
     *----------------------------------------*/

    /**
     * Check if file exists
     *
     * @return bool
     */
    public function exists(): bool;

    /**
     * Check if parent directory exists
     *
     * @return bool
     */
    public function parentExists(): bool;

    /**
     * Check if path isdirectory
     *
     * @return bool
     */
    public function isDirectory(): bool;

    /**
     * Check if path isregular file
     *
     * @return bool
     */
    public function isFile(): bool;

    /**
     * Check if path issymbolic link
     *
     * @return bool
     */
    public function isLink(): bool;

    /**
     * Check if file is readable
     *
     * @return bool
     */
    public function isReadable(): bool;

    /**
     * Check if file is writable
     *
     * @return bool
     */
    public function isWritable(): bool;

    /**
     * Check if file is executable
     *
     * @return bool
     */
    public function isExecutable(): bool;

    /**
     * Determine ifoperating system is Windows
     *
     * @return bool
     */
    public function isWindows(): bool;

    /*----------------------------------------*
     * Hash
     *----------------------------------------*/

    /**
     * Get file hash
     *
     * @param string $algorithm
     * @return string|null
     */
    public function hash(string $algorithm = "sha256"): string|null;

    /*----------------------------------------*
     * Statistics
     *----------------------------------------*/

    /**
     * Get system information aboutfile
     *
     * @return array<string, int|string>|null
     */
    public function statistics(): array|null;
}
