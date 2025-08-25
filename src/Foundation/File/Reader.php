<?php

namespace Spark\Foundation\File;

use Spark\File\Pathinfo;

/**
 * File Reader
 *
 * @package Spark\Foundation\File
 */
abstract class Reader extends Pathinfo
{
    /*----------------------------------------*
     * Read
     *----------------------------------------*/

    /**
     * read file
     *
     * @return array
     */
    public function read(): array
    {
        return iterator_to_array($this->lines(), false);
    }

    /**
     * iterate through file lines
     *
     * @param int $start
     * @return \Generator
     */
    public function lines(int $start = 1): \Generator
    {
        $file = $this->openFileObject();

        if ($file === null) return;

        if ($start > 1) $file->seek($start - 1);

        yield from $this->iterateFile($file);
    }

    /**
     * get file object
     *
     * @param string $mode
     * @return \SplFileObject|null
     */
    protected function openFileObject(string $mode = "r"): \SplFileObject|null
    {
        if (!$this->validate()) return null;

        try {
            return new \SplFileObject($this->path(), $mode);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * iterate file
     *
     * @param \SplFileObject $file
     * @return \Generator
     */
    abstract protected function iterateFile(\SplFileObject $file): \Generator;

    /**
     * iterate through file chunks
     *
     * @param int $row
     * @param int $start
     * @return \Generator
     */
    public function chunks(int $row = 1, int $start = 1): \Generator
    {
        $chunk = [];

        foreach ($this->lines($start) as $line) {
            $chunk[] = $line;

            if (count($chunk) >= $row) {
                yield $chunk;

                $chunk = [];
            }
        }

        if (count($chunk) > 0) yield $chunk;
    }

    /*----------------------------------------*
     * Stream
     *----------------------------------------*/

    /**
     * iterate through file stream
     *
     * @param int $start
     * @return \Generator
     */
    public function stream(int $start = 1): \Generator
    {
        $stream = $this->openStream();

        if ($stream === null) return;

        try {
            for ($i = 1; $i < $start; $i++) {
                if (fgets($stream) === false) break;
            }

            yield from $this->iterateStream($stream);
        } finally {
            fclose($stream);
        }
    }

    /**
     * get file stream
     *
     * @param string $mode
     * @return resource|null
     */
    protected function openStream(string $mode = "r")
    {
        if (!$this->validate()) return null;

        return fopen($this->path(), $mode);
    }

    /**
     * iterate stream
     *
     * @param resource $stream
     * @return \Generator
     */
    abstract protected function iterateStream($stream): \Generator;

    /*----------------------------------------*
     * Collection
     *----------------------------------------*/

    /**
     * map rows by callback
     *
     * @param callable $callback
     * @param int $start
     * @return \Generator
     */
    public function map(callable $callback, int $start = 1): \Generator
    {
        foreach ($this->lines($start) as $line) {
            yield $callback($line);
        }
    }

    /**
     * filter rows by callback
     *
     * @param callable $callback
     * @param int $start
     * @return \Generator
     */
    public function filter(callable $callback, int $start = 1): \Generator
    {
        foreach ($this->lines($start) as $line) {
            if (!$callback($line)) continue;

            yield $line;
        }
    }

    /*----------------------------------------*
     * Count
     *----------------------------------------*/

    /**
     * count lines
     *
     * @return int
     */
    public function count(): int
    {
        $count = 0;

        foreach ($this->lines() as $line) {
            $count++;
        }

        return $count;
    }

    /*----------------------------------------*
     * Validate
     *----------------------------------------*/

    /**
     * validate file
     *
     * @return bool
     */
    public function validate(): bool
    {
        if (!$this->isExists()) return false;

        if (!$this->isReadable()) return false;

        return true;
    }
}
