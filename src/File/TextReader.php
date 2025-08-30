<?php

declare(strict_types=1);

namespace Spark\File;

use Spark\Contracts\File\TextReader as TextReaderContract;
use Spark\Foundation\File\Reader;

/**
 * Text File Reader
 *
 * @package Spark\File
 */
class TextReader extends Reader implements TextReaderContract
{
    /*----------------------------------------*
     * Trim
     *----------------------------------------*/

    /**
     * Whether to trim line endings
     *
     * @var bool
     */
    protected bool $trimLineEndings = true;

    /**
     * {@inheritDoc}
     */
    public function setTrimLineEndings(bool $trimLineEndings): static
    {
        $this->trimLineEndings = $trimLineEndings;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function trimLineEndings(): bool
    {
        return $this->trimLineEndings;
    }

    /*----------------------------------------*
     * Skip
     *----------------------------------------*/

    /**
     * Whether to skip empty lines
     *
     * @var bool
     */
    protected bool $skipEmpty = false;

    /**
     * {@inheritDoc}
     */
    public function setSkipEmpty(bool $skipEmpty): static
    {
        $this->skipEmpty = $skipEmpty;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function skipEmpty(): bool
    {
        return $this->skipEmpty;
    }

    /*----------------------------------------*
     * Read
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    protected function iterateFile(\SplFileObject $file): \Generator
    {
        foreach ($file as $line) {
            if ($line === false) continue;

            $processedLine = $this->processLine($line);

            if ($processedLine === null) continue;

            yield $processedLine;
        }
    }

    /*----------------------------------------*
     * Stream
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    protected function iterateStream($stream): \Generator
    {
        while (($line = fgets($stream)) !== false) {
            $processedLine = $this->processLine($line);

            if ($processedLine === null) continue;

            yield $processedLine;
        }
    }

    /*----------------------------------------*
     * Process
     *----------------------------------------*/

    /**
     * Process single line
     *
     * @param string $line
     * @return string|null
     */
    protected function processLine(string $line): string|null
    {
        if ($this->trimLineEndings()) $line = rtrim($line, "\r\n");

        if ($this->skipEmpty() && trim($line) === "") return null;

        if ($this->encoding() !== "UTF-8") $line = $this->convertEncoding($line);

        return $line;
    }
}
