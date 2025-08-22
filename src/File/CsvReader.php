<?php

namespace Spark\File;

use Spark\Foundation\File\Reader;

/**
 * File CSV Reader
 *
 * @package Spark\File
 */
class CsvReader extends Reader
{
    /*----------------------------------------*
     * Control
     *----------------------------------------*/

    /**
     * delimiter
     *
     * @var string
     */
    protected string $delimiter = ",";

    /**
     * enclosure
     *
     * @var string
     */
    protected string $enclosure = "\"";

    /**
     * escape
     *
     * @var string
     */
    protected string $escape = "\\";

    /**
     * set delimiter
     *
     * @param string $delimiter
     * @return static
     */
    public function setDelimiter(string $delimiter): static
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * get delimiter
     *
     * @return string
     */
    public function delimiter(): string
    {
        return $this->delimiter;
    }

    /**
     * set enclosure
     *
     * @param string $enclosure
     * @return static
     */
    public function setEnclosure(string $enclosure): static
    {
        $this->enclosure = $enclosure;

        return $this;
    }

    /**
     * get enclosure
     *
     * @return string
     */
    public function enclosure(): string
    {
        return $this->enclosure;
    }

    /**
     * set escape
     *
     * @param string $escape
     * @return static
     */
    public function setEscape(string $escape): static
    {
        $this->escape = $escape;

        return $this;
    }

    /**
     * get escape
     *
     * @return string
     */
    public function escape(): string
    {
        return $this->escape;
    }

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
        return iterator_to_array($this->rows(), false);
    }

    /**
     * iterate through file rows
     *
     * @param int $start
     * @return \Generator
     */
    public function rows(int $start = 1): \Generator
    {
        $file = $this->openFileObject();

        if ($file === null) return;

        $file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY | \SplFileObject::DROP_NEW_LINE);
        $file->setCsvControl($this->delimiter, $this->enclosure, $this->escape);

        if ($start > 1) $file->seek($start - 1);

        $hasHeader  = $this->hasHeader();
        $headers    = null;
        $isFirstRow = true;

        foreach ($file as $row) {
            if ($row === false || !is_array($row)) continue;

            if (!$hasHeader) {
                yield $row;

                continue;
            }

            if ($isFirstRow) {
                $headers = array_map("trim", $row);

                $this->headers = $headers;

                $isFirstRow = false;

                continue;
            }

            if ($headers === null) {
                yield $row;

                continue;
            }

            $headerCount = count($headers);

            $row = array_pad($row, $headerCount, null);
            $row = array_slice($row, 0, $headerCount);

            $combined = array_combine($headers, $row);

            if ($combined !== false) yield $combined;
        }
    }

    /*----------------------------------------*
     * Header
     *----------------------------------------*/

    /**
     * whether file has header
     *
     * @var bool
     */
    protected bool $hasHeader = true;

    /**
     * headers
     *
     * @var array<string>
     */
    protected array $headers = [];

    /**
     * set has header
     *
     * @param bool $hasHeader
     * @return static
     */
    public function setHasHeader(bool $hasHeader): static
    {
        $this->hasHeader = $hasHeader;

        $this->headers = [];

        return $this;
    }

    /**
     * whether has header
     *
     * @return bool
     */
    public function hasHeader(): bool
    {
        return $this->hasHeader;
    }

    /**
     * get headers
     *
     * @return array<string>
     */
    public function headers(): array
    {
        if (!empty($this->headers)) return $this->headers;

        if (!$this->hasHeader()) return [];

        $file = $this->openFileObject();

        if ($file === null) return [];

        $file->setFlags(\SplFileObject::READ_CSV);
        $file->setCsvControl($this->delimiter, $this->enclosure, $this->escape);

        $row = $file->fgetcsv();

        if ($row === false || !is_array($row)) return [];

        $this->headers = array_map("trim", $row);

        return $this->headers;
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
        return ["csv", "tsv"];
    }

    /**
     * validate file format
     *
     * @return bool
     */
    protected function validateFormat(): bool
    {
        $file = $this->openFileObject();

        if ($file === null) return false;

        $line = $file->fgets();

        if ($line === false) return false;

        $data = str_getcsv($line, $this->delimiter, $this->enclosure, $this->escape);

        return is_array($data);
    }
}
