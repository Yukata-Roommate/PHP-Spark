<?php

namespace Spark\Foundation\File;

use Spark\File\Operator;

/**
 * File Writer
 *
 * @package Spark\Foundation\File
 */
abstract class Writer extends Operator
{
    /*----------------------------------------*
     * Write File
     *----------------------------------------*/

    /**
     * write content
     *
     * @param array $data
     * @param bool $append
     * @return bool
     */
    protected function writeData(array $data, bool $append): bool
    {
        $handle = fopen($this->path(), $append ? "a" : "w");

        if ($handle === false) return false;

        if ($this->lockEx()) flock($handle, LOCK_EX);

        foreach ($data as $line) {
            if (!$this->validate($line)) continue;

            $content = $this->format($line) . $this->newLine();

            if ($this->encoding() !== "UTF-8") $content = mb_convert_encoding($content, $this->encoding(), "UTF-8");

            fwrite($handle, $content);
        }

        if ($this->lockEx()) flock($handle, LOCK_UN);

        fclose($handle);

        return true;
    }

    /**
     * validate line
     *
     * @param mixed $line
     * @return bool 
     */
    abstract protected function validate(mixed $line): bool;

    /**
     * format line to string
     *
     * @param mixed $line
     * @return string
     */
    abstract protected function format(mixed $line): string;

    /*----------------------------------------*
     * Write
     *----------------------------------------*/

    /**
     * write content to file
     *
     * @param string $data
     * @return bool
     */
    public function write(string $data): bool
    {
        return $this->writeData([$data], false);
    }

    /**
     * write lines to file
     *
     * @param array<string> $lines
     * @return bool
     */
    public function writeLines(array $lines): bool
    {
        return $this->writeData($lines, false);
    }

    /**
     * append content to file
     *
     * @param string $data
     * @return bool
     */
    public function append(string $data): bool
    {
        return $this->writeData([$data], true);
    }

    /**
     * append lines to file
     *
     * @param array<string> $lines
     * @return bool
     */
    public function appendLines(array $lines): bool
    {
        return $this->writeData($lines, true);
    }

    /*----------------------------------------*
     * Lock Exclusive
     *----------------------------------------*/

    /**
     * whether to use LOCK_EX flag
     *
     * @var bool
     */
    protected bool $lockEx = false;

    /**
     * set whether to use LOCK_EX flag
     *
     * @param bool $lockEx
     * @return $this
     */
    public function setLockEx(bool $lockEx = true): static
    {
        $this->lockEx = $lockEx;

        return $this;
    }

    /**
     * whether to use LOCK_EX flag
     *
     * @return bool
     */
    public function lockEx(): bool
    {
        return $this->lockEx;
    }

    /*----------------------------------------*
     * New Line
     *----------------------------------------*/

    /**
     * new line character
     *
     * @var string
     */
    protected string $newLine = PHP_EOL;

    /**
     * set new line character
     *
     * @param string $newLine
     * @return $this
     */
    public function setNewLine(string $newLine): static
    {
        $this->newLine = $newLine;

        return $this;
    }

    /**
     * get new line character
     *
     * @return string
     */
    public function newLine(): string
    {
        return $this->newLine;
    }

    /*----------------------------------------*
     * Encoding
     *----------------------------------------*/

    /**
     * file encoding
     *
     * @var string
     */
    protected string $encoding = "UTF-8";

    /**
     * set file encoding
     *
     * @param string $encoding
     * @return $this
     */
    public function setEncoding(string $encoding): static
    {
        $this->encoding = $encoding;

        return $this;
    }

    /**
     * get file encoding
     *
     * @return string
     */
    public function encoding(): string
    {
        return $this->encoding;
    }
}
