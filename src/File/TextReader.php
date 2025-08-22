<?php

namespace Spark\File;

use Spark\Foundation\File\Reader;

/**
 * File Text Reader
 *
 * @package Spark\File
 */
class TextReader extends Reader
{
    /*----------------------------------------*
     * Read
     *----------------------------------------*/

    /**
     * read file
     *
     * @return string|null
     */
    public function read(): string|null
    {
        return $this->readRaw();
    }

    /**
     * read file lines
     *
     * @param int $start
     * @return array
     */
    public function readLines(int $start = 1): array
    {
        if (!$this->validate()) return [];
    
        return iterator_to_array($this->lines($start), false);
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

        foreach ($file as $line) {
            if ($line === false) continue;

            yield rtrim($line, "\n\r");
        }
    }

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

            while (($line = fgets($stream)) !== false) {
                yield rtrim($line, "\n\r");
            }
        } finally {
            fclose($stream);
        }
    }

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
     * Validate
     *----------------------------------------*/

    /**
     * get supported file extensions
     *
     * @return array
     */
    public function supportedExtensions(): array
    {
        return ["txt", "log", "conf", "ini", "env"];
    }

    /**
     * validate file format
     *
     * @return bool
     */
    protected function validateFormat(): bool
    {
        return true;
    }
}
