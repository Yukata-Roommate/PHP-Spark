<?php

namespace Spark\File;

use Spark\Foundation\File\Reader;

/**
 * CSV File Reader
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
        $file->setCsvControl($this->delimiter(), $this->enclosure(), $this->escape());

        $row = $file->fgetcsv();

        if ($row === false || empty($row) || $row === [null]) return [];

        $this->headers = array_map("trim", $row);

        return $this->headers;
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
        $file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY | \SplFileObject::DROP_NEW_LINE);
        $file->setCsvControl($this->delimiter(), $this->enclosure(), $this->escape());

        $hasHeader  = $this->hasHeader();
        $headers    = null;
        $isFirstRow = true;

        foreach ($file as $row) {
            if (empty($row) || $row === [null]) continue;

            $processed = $this->processRow($row, $hasHeader, $headers, $isFirstRow);

            if ($processed === false) continue;

            yield $processed;
        }
    }

    /**
     * process row data
     *
     * @param array $row
     * @param bool $hasHeader
     * @param array|null &$headers
     * @param bool &$isFirstRow
     * @return array|null
     */
    protected function processRow(array $row, bool $hasHeader, ?array &$headers, bool &$isFirstRow): ?array
    {
        if (!$hasHeader) return $row;

        if ($isFirstRow) {
            $headers = array_map("trim", $row);

            $this->headers = $headers;

            $isFirstRow = false;

            return null;
        }

        if (!$headers) return $row;

        $headerCount = count($headers);

        $row = array_pad($row, $headerCount, null);
        $row = array_slice($row, 0, $headerCount);

        return array_combine($headers, $row);
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
        $hasHeader  = $this->hasHeader();
        $headers    = null;
        $isFirstRow = true;

        while (($row = fgetcsv($stream, 0, $this->delimiter(), $this->enclosure(), $this->escape())) !== false) {
            if (empty($row) || $row === [null]) continue;

            $processed = $this->processRow($row, $hasHeader, $headers, $isFirstRow);

            if ($processed === false) continue;

            yield $processed;
        }
    }
}
