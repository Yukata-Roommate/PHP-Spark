<?php

declare(strict_types=1);

namespace Spark\Contracts\File;

use Spark\Contracts\File\Pathinfo;

/**
 * File Reader Contract
 *
 * @package Spark\Contracts\File
 */
interface Reader extends Pathinfo
{
    /*----------------------------------------*
     * Read
     *----------------------------------------*/

    /**
     * Read entire file into array
     *
     * @return array
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\ReadException
     */
    public function read(): array;

    /**
     * Iterate through file lines
     *
     * @param int $start
     * @return \Generator
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\ReadException
     */
    public function lines(int $start = 1): \Generator;

    /**
     * Iterate through file chunks
     *
     * @param int $rows Number of rows per chunk
     * @param int $start
     * @return \Generator
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\ReadException
     */
    public function chunks(int $rows = 1, int $start = 1): \Generator;

    /*----------------------------------------*
     * Stream
     *----------------------------------------*/

    /**
     * Iterate through file using stream
     *
     * @param int $start
     * @return \Generator
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\ReadException
     */
    public function stream(int $start = 1): \Generator;

    /*----------------------------------------*
     * Collection
     *----------------------------------------*/

    /**
     * Map callback to each line
     *
     * @param callable $callback
     * @param int $start
     * @return \Generator
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\ReadException
     */
    public function map(callable $callback, int $start = 1): \Generator;

    /**
     * Filter lines by callback
     *
     * @param callable $callback
     * @param int $start
     * @return \Generator
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\ReadException
     */
    public function filter(callable $callback, int $start = 1): \Generator;

    /**
     * Count lines in file
     *
     * @return int
     * @throws \Spark\Exceptions\File\NotFoundException
     * @throws \Spark\Exceptions\File\ReadException
     */
    public function count(): int;

    /*----------------------------------------*
     * Validate
     *----------------------------------------*/

    /**
     * Validate if file can be read
     *
     * @return bool
     */
    public function validate(): bool;

    /*----------------------------------------*
     * Encoding
     *----------------------------------------*/

    /**
     * Set file encoding for reading
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
