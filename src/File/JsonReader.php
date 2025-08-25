<?php

namespace Spark\File;

use Spark\Foundation\File\Reader;

/**
 * JSON File Reader
 *
 * @package Spark\File
 */
class JsonReader extends Reader
{
    /*----------------------------------------*
     * JSON
     *----------------------------------------*/

    /**
     * decode flags
     *
     * @var int
     */
    protected int $flags = 0;

    /**
     * max depth
     *
     * @var int
     */
    protected int $depth = 512;

    /**
     * whether to return associative array
     *
     * @var bool
     */
    protected bool $assoc = true;

    /**
     * set decode flags
     *
     * @param int $flags
     * @return static
     */
    public function setFlags(int $flags): static
    {
        $this->flags = $flags;

        return $this;
    }

    /**
     * add decode flag
     *
     * @param int $flag
     * @return static
     */
    public function addFlag(int $flag): static
    {
        $this->flags |= $flag;

        return $this;
    }

    /**
     * remove decode flag
     *
     * @param int $flag
     * @return static
     */
    public function removeFlag(int $flag): static
    {
        $this->flags &= ~$flag;

        return $this;
    }

    /**
     * clear decode flags
     *
     * @return static
     */
    public function clearFlags(): static
    {
        $this->flags = 0;

        return $this;
    }

    /**
     * get decode flags
     *
     * @return int
     */
    public function flags(): int
    {
        return $this->flags;
    }

    /**
     * set max depth
     *
     * @param int $depth
     * @return static
     */
    public function setDepth(int $depth): static
    {
        $this->depth = $depth;

        return $this;
    }

    /**
     * get max depth
     *
     * @return int
     */
    public function depth(): int
    {
        return $this->depth;
    }

    /**
     * set whether to return associative array
     *
     * @param bool $assoc
     * @return static
     */
    public function setAssoc(bool $assoc): static
    {
        $this->assoc = $assoc;

        return $this;
    }

    /**
     * whether to return associative array
     *
     * @return bool
     */
    public function assoc(): bool
    {
        return $this->assoc;
    }

    /*----------------------------------------*
     * Read
     *----------------------------------------*/

    /**
     * iterate file
     *
     * @param \SplFileObject $file
     * @return \Generator
     */
    protected function iterateFile(\SplFileObject $file): \Generator
    {
        foreach ($file as $line) {
            if ($line === false) continue;

            yield json_decode(
                rtrim($line, "\n\r"),
                $this->assoc(),
                $this->depth(),
                $this->flags()
            );
        }
    }

    /*----------------------------------------*
     * Stream
     *----------------------------------------*/

    /**
     * iterate stream
     *
     * @param resource $stream
     * @return \Generator
     */
    protected function iterateStream($stream): \Generator
    {
        while (($line = fgets($stream)) !== false) {
            yield json_decode(
                rtrim($line, "\n\r"),
                $this->assoc(),
                $this->depth(),
                $this->flags()
            );
        }
    }
}
