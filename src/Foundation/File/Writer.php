<?php

declare(strict_types=1);

namespace Spark\Foundation\File;

use Spark\Contracts\File\Writer as WriterContract;
use Spark\File\Operator;

use Spark\Exceptions\File\WriteException;
use Spark\Exceptions\File\EncodingException;

/**
 * File Writer
 *
 * @package Spark\Foundation\File
 */
abstract class Writer extends Operator implements WriterContract
{
    /*----------------------------------------*
     * Write
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function write(string $data): bool
    {
        return $this->persistData([$data], false);
    }

    /**
     * {@inheritDoc}
     */
    public function writeLines(array $lines): bool
    {
        return $this->persistData($lines, false);
    }

    /*----------------------------------------*
     * Append
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function append(string $data): bool
    {
        return $this->persistData([$data], true);
    }

    /**
     * {@inheritDoc}
     */
    public function appendLines(array $lines): bool
    {
        return $this->persistData($lines, true);
    }

    /*----------------------------------------*
     * Persistence
     *----------------------------------------*/

    /**
     * Format data for writing
     *
     * @param mixed $data
     * @return string
     */
    abstract protected function format(mixed $data): string;

    /**
     * Persist data to file
     *
     * @param array $data
     * @param bool $append
     * @return bool
     * @throws \Spark\Exceptions\File\WriteException
     * @throws \Spark\Exceptions\File\EncodingException
     */
    protected function persistData(array $data, bool $append): bool
    {
        if (!$this->parentExists()) $this->createParentDirectory();

        $handle = @fopen($this->path, $append ? "a" : "w");

        if ($handle === false) throw new WriteException($this->path);

        try {
            if ($this->lockEx) flock($handle, LOCK_EX);

            $this->processContent($handle, $data, $append);

            if ($this->lockEx) flock($handle, LOCK_UN);

            fclose($handle);

            $this->clearCache();

            return true;
        } catch (\Exception $e) {
            if ($this->lockEx) flock($handle, LOCK_UN);

            fclose($handle);

            throw $e;
        }
    }

    /**
     * Process writing content to file
     *
     * @param resource $handle
     * @param array $data
     * @param bool $append
     * @return void
     * @throws \Spark\Exceptions\File\WriteException
     * @throws \Spark\Exceptions\File\EncodingException
     */
    protected function processContent($handle, array $data, bool $append): void
    {
        foreach ($data as $line) {
            $this->flushLine($handle, $line);
        }
    }

    /**
     * Flush single line to file
     *
     * @param resource $handle
     * @param mixed $line
     * @return void
     * @throws \Spark\Exceptions\File\WriteException
     * @throws \Spark\Exceptions\File\EncodingException
     */
    protected function flushLine($handle, mixed $line): void
    {
        $content = $this->format($line);

        if ($this->encoding !== "UTF-8") {
            $converted = @mb_convert_encoding($content, $this->encoding, "UTF-8");

            if ($converted === false) throw new EncodingException($this->path, "UTF-8", $this->encoding);

            $content = $converted;
        }

        $written = fwrite($handle, $content);

        if ($written === false) throw new WriteException($this->path);
    }

    /*----------------------------------------*
     * Lock Exclusive
     *----------------------------------------*/

    /**
     * Whether to use LOCK_EX flag
     *
     * @var bool
     */
    protected bool $lockEx = false;

    /**
     * {@inheritDoc}
     */
    public function setLockEx(bool $lockEx = true): static
    {
        $this->lockEx = $lockEx;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function lockEx(): bool
    {
        return $this->lockEx;
    }

    /*----------------------------------------*
     * New Line
     *----------------------------------------*/

    /**
     * New line character
     *
     * @var string
     */
    protected string $newLine = PHP_EOL;

    /**
     * {@inheritDoc}
     */
    public function setNewLine(string $newLine): static
    {
        $this->newLine = $newLine;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function newLine(): string
    {
        return $this->newLine;
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
}
