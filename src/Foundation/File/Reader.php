<?php

declare(strict_types=1);

namespace Spark\Foundation\File;

use Spark\Contracts\File\Reader as ReaderContract;
use Spark\File\Pathinfo;

use Spark\Exceptions\File\ReadException;
use Spark\Exceptions\File\EncodingException;

/**
 * File Reader
 *
 * @package Spark\Foundation\File
 */
abstract class Reader extends Pathinfo implements ReaderContract
{
    /*----------------------------------------*
     * Open File
     *----------------------------------------*/

    /**
     * Open file object for reading
     *
     * @param string $mode
     * @return \SplFileObject|null
     */
    protected function openFileObject(string $mode = "r"): \SplFileObject|null
    {
        if (!$this->validate()) return null;

        try {
            return new \SplFileObject($this->path, $mode);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Open stream for reading
     *
     * @param string $mode
     * @return resource|null
     */
    protected function openStream(string $mode = "r")
    {
        if (!$this->validate()) return null;

        $stream = @fopen($this->path, $mode);

        if ($stream === false) return null;

        return $stream;
    }

    /*----------------------------------------*
     * Read
     *----------------------------------------*/

    /**
     * Iterate through file using SplFileObject
     *
     * @param \SplFileObject $file
     * @return \Generator
     */
    abstract protected function iterateFile(\SplFileObject $file): \Generator;

    /**
     * {@inheritDoc}
     */
    public function read(): array
    {
        return iterator_to_array($this->lines(), false);
    }

    /**
     * {@inheritDoc}
     */
    public function lines(int $start = 1): \Generator
    {
        $file = $this->openFileObject();

        if ($file === null) throw new ReadException($this->path);

        try {
            if ($start > 1) $file->seek($start - 1);

            yield from $this->iterateFile($file);
        } catch (\Exception $e) {
            if (!($e instanceof ReadException)) throw new ReadException($this->path);

            throw $e;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function chunks(int $rows = 1, int $start = 1): \Generator
    {
        $chunk = [];

        foreach ($this->lines($start) as $line) {
            $chunk[] = $line;

            if (count($chunk) >= $rows) {
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
     * Iterate through file using stream
     *
     * @param resource $stream
     * @return \Generator
     */
    abstract protected function iterateStream($stream): \Generator;

    /**
     * {@inheritDoc}
     */
    public function stream(int $start = 1): \Generator
    {
        $stream = $this->openStream();

        if ($stream === null) throw new ReadException($this->path);

        try {
            for ($i = 1; $i < $start; $i++) {
                if (fgets($stream) === false) break;
            }

            yield from $this->iterateStream($stream);
        } catch (\Exception $e) {
            if (!($e instanceof ReadException)) throw new ReadException($this->path);

            throw $e;
        } finally {
            fclose($stream);
        }
    }

    /*----------------------------------------*
     * Collection
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function map(callable $callback, int $start = 1): \Generator
    {
        foreach ($this->lines($start) as $line) {
            yield $callback($line);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function filter(callable $callback, int $start = 1): \Generator
    {
        foreach ($this->lines($start) as $line) {
            if ($callback($line)) yield $line;
        }
    }

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function validate(): bool
    {
        if (!$this->issetPath()) return false;

        if (!$this->exists()) return false;

        if (!$this->isFile()) return false;

        if (!$this->isReadable()) return false;

        return true;
    }

    /*----------------------------------------*
     * Encoding
     *----------------------------------------*/

    /**
     * File encoding
     *
     * @var string
     */
    protected string $encoding = "UTF-8";

    /**
     * {@inheritDoc}
     */
    public function setEncoding(string $encoding): static
    {
        $this->encoding = $encoding;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function encoding(): string
    {
        return $this->encoding;
    }

    /**
     * Convert encoding of content
     *
     * @param string $content
     * @return string
     * @throws \Spark\Exceptions\File\EncodingException
     */
    protected function convertEncoding(string $content): string
    {
        if ($this->encoding() === "UTF-8") return $content;

        $converted = @mb_convert_encoding($content, "UTF-8", $this->encoding());

        if ($converted === false) throw new EncodingException($this->path, $this->encoding(), "UTF-8");

        return $converted;
    }

    /**
     * Detect encoding of content
     *
     * @param string $content
     * @return string|null
     */
    protected function detectEncoding(string $content): string|null
    {
        $detected = mb_detect_encoding(
            $content,
            ["UTF-8", "ISO-8859-1", "SJIS", "EUC-JP", "ASCII"],
            true
        );

        return $detected !== false ? $detected : null;
    }
}
