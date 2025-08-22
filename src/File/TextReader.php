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

        $data = file($this->path(), FILE_IGNORE_NEW_LINES);

        if (!is_array($data)) return [];

        return array_slice($data, $start - 1);
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

        $loop = 0;

        while (!$file->eof()) {
            $loop++;

            $line = $file->fgets();

            if ($loop < $start) continue;

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

        $loop = 0;

        try {
            while (($line = fgets($stream)) !== false) {
                $loop++;

                if ($loop < $start) continue;

                yield rtrim($line, "\n\r");
            }
        } finally {
            fclose($stream);
        }
    }

    /**
     * read file by chunk
     *
     * @param int $row
     * @param int $start
     * @return array
     */
    public function readByChunk(int $row = 1, int $start = 1): array
    {
        $data = $this->readLines($start);

        if (empty($data)) return [];

        return array_chunk($data, $row);
    }

    /**
     * iterate through file by chunk
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

            if (count($chunk) < $row) continue;

            yield $chunk;

            $chunk = [];
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
