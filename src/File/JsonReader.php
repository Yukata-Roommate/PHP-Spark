<?php

declare(strict_types=1);

namespace Spark\File;

use Spark\Contracts\File\JsonReader as JsonReaderContract;
use Spark\Foundation\File\Reader;

use Spark\Exceptions\File\JsonFormatException;

/**
 * JSON File Reader
 *
 * @package Spark\File
 */
class JsonReader extends Reader implements JsonReaderContract
{
    /*----------------------------------------*
     * JSON
     *----------------------------------------*/

    /**
     * JSON decode flags
     *
     * @var int
     */
    protected int $flags = 0;

    /**
     * Maximum depth
     *
     * @var int
     */
    protected int $depth = 512;

    /**
     * Return associative arrays
     *
     * @var bool
     */
    protected bool $assoc = true;

    /**
     * {@inheritDoc}
     */
    public function setFlags(int $flags): static
    {
        $this->flags = $flags;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function addFlag(int $flag): static
    {
        $this->flags |= $flag;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removeFlag(int $flag): static
    {
        $this->flags &= ~$flag;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function clearFlags(): static
    {
        $this->flags = 0;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function flags(): int
    {
        return $this->flags;
    }

    /**
     * {@inheritDoc}
     */
    public function setDepth(int $depth): static
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function depth(): int
    {
        return $this->depth;
    }

    /**
     * {@inheritDoc}
     */
    public function setAssoc(bool $assoc): static
    {
        $this->assoc = $assoc;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function assoc(): bool
    {
        return $this->assoc;
    }

    /*----------------------------------------*
     * Read
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     *
     * @throws \Spark\Exceptions\File\ReadException
     * @throws \Spark\Exceptions\File\JsonFormatException
     */
    protected function iterateFile(\SplFileObject $file): \Generator
    {
        $lineNumber = 0;

        foreach ($file as $line) {
            $lineNumber++;

            if ($line === false || trim($line) === "") continue;

            $decoded = $this->processRow($line);

            if ($decoded !== null) yield $decoded;
        }
    }

    /*----------------------------------------*
     * Stream
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     *
     * @throws \Spark\Exceptions\File\ReadException
     * @throws \Spark\Exceptions\File\JsonFormatException
     */
    protected function iterateStream($stream): \Generator
    {
        while (($line = fgets($stream)) !== false) {
            $line = trim($line);

            if ($line === "") continue;

            $decoded = $this->processRow($line);

            if ($decoded !== null) yield $decoded;
        }
    }

    /*----------------------------------------*
     * Process
     *----------------------------------------*/

    /**
     * Process JSON row
     *
     * @param string $line
     * @return mixed
     * @throws \Spark\Exceptions\File\JsonFormatException
     */
    protected function processRow(string $line): mixed
    {
        $line = rtrim($line, "\r\n");

        if (trim($line) === "") return null;

        if ($this->encoding() !== "UTF-8") $line = $this->convertEncoding($line);

        $decoded = json_decode(
            $line,
            $this->assoc(),
            $this->depth(),
            $this->flags()
        );

        if (json_last_error() !== JSON_ERROR_NONE) throw new JsonFormatException($this->path, "decode", json_last_error_msg());

        return $decoded;
    }
}
