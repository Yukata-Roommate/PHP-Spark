<?php

declare(strict_types=1);

namespace Spark\File;

use Spark\Contracts\File\JsonWriter as JsonWriterContract;
use Spark\Foundation\File\Writer;

use Spark\Exceptions\File\JsonFormatException;

/**
 * JSON File Writer
 *
 * @package Spark\File
 */
class JsonWriter extends Writer implements JsonWriterContract
{
    /*----------------------------------------*
     * JSON
     *----------------------------------------*/

    /**
     * JSON encode flags
     *
     * @var int
     */
    protected int $flags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;

    /**
     * Maximum depth
     *
     * @var int
     */
    protected int $depth = 512;

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

    /*----------------------------------------*
     * Format
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     *
     * @throws \Spark\Exceptions\File\JsonFormatException
     */
    protected function format(mixed $data): string
    {
        $flags = $this->flags & ~JSON_PRETTY_PRINT;

        $json = json_encode($data, $flags, $this->depth);

        if ($json === false) throw new JsonFormatException($this->path, "encode", json_last_error_msg());

        return $json . $this->newLine;
    }
}
