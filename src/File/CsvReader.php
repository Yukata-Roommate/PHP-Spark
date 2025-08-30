<?php

declare(strict_types=1);

namespace Spark\File;

use Spark\Contracts\File\CsvReader as CsvReaderContract;
use Spark\Foundation\File\Reader;

use Spark\Exceptions\File\ReadException;

/**
 * CSV File Reader
 *
 * @package Spark\File
 */
class CsvReader extends Reader implements CsvReaderContract
{
    /*----------------------------------------*
     * Control
     *----------------------------------------*/

    /**
     * CSV delimiter
     *
     * @var string
     */
    protected string $delimiter = ",";

    /**
     * CSV enclosure
     *
     * @var string
     */
    protected string $enclosure = "\"";

    /**
     * CSV escape character
     *
     * @var string
     */
    protected string $escape = "\\";

    /**
     * {@inheritDoc}
     */
    public function setDelimiter(string $delimiter): static
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function delimiter(): string
    {
        return $this->delimiter;
    }

    /**
     * {@inheritDoc}
     */
    public function setEnclosure(string $enclosure): static
    {
        $this->enclosure = $enclosure;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function enclosure(): string
    {
        return $this->enclosure;
    }

    /**
     * {@inheritDoc}
     */
    public function setEscape(string $escape): static
    {
        $this->escape = $escape;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function escape(): string
    {
        return $this->escape;
    }

    /*----------------------------------------*
     * Header
     *----------------------------------------*/

    /**
     * Whether file has header
     *
     * @var bool
     */
    protected bool $hasHeader = true;

    /**
     * Headers cache
     *
     * @var array<string>
     */
    protected array $headers = [];

    /**
     * {@inheritDoc}
     */
    public function setHasHeader(bool $hasHeader): static
    {
        $this->hasHeader = $hasHeader;
        $this->headers = [];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function hasHeader(): bool
    {
        return $this->hasHeader;
    }

    /**
     * {@inheritDoc}
     */
    public function headers(): array
    {
        if (!empty($this->headers)) return $this->headers;

        if (!$this->hasHeader()) return [];

        $file = $this->openFileObject();

        if ($file === null) throw new ReadException($this->path);

        $file->setFlags(\SplFileObject::READ_CSV);
        $file->setCsvControl($this->delimiter(), $this->enclosure(), $this->escape());

        $row = $file->fgetcsv();

        if ($row === false || empty($row) || $row === [null]) return [];

        $this->headers = $this->trimValues()
            ? array_map("trim", $row)
            : $row;

        return $this->headers;
    }

    /**
     * {@inheritDoc}
     */
    public function setHeaders(array $headers): static
    {
        $this->headers = $headers;

        return $this;
    }

    /*----------------------------------------*
     * Trim
     *----------------------------------------*/

    /**
     * Whether to trim values
     *
     * @var bool
     */
    protected bool $trimValues = true;

    /**
     * {@inheritDoc}
     */
    public function setTrimValues(bool $trimValues): static
    {
        $this->trimValues = $trimValues;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function trimValues(): bool
    {
        return $this->trimValues;
    }

    /*----------------------------------------*
     * Skip
     *----------------------------------------*/

    /**
     * Whether to skip empty lines
     *
     * @var bool
     */
    protected bool $skipEmpty = true;

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
        $flags = \SplFileObject::READ_CSV;

        if ($this->skipEmpty()) $flags |= \SplFileObject::SKIP_EMPTY | \SplFileObject::DROP_NEW_LINE;

        $file->setFlags($flags);
        $file->setCsvControl($this->delimiter(), $this->enclosure(), $this->escape());

        $hasHeader  = $this->hasHeader();
        $headers    = null;
        $isFirstRow = true;

        foreach ($file as $row) {
            if (empty($row) || $row === [null]) continue;

            $processed = $this->processRow($row, $hasHeader, $headers, $isFirstRow);

            if ($processed === null) continue;

            yield $processed;
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
        $hasHeader  = $this->hasHeader();
        $headers    = null;
        $isFirstRow = true;

        while (($row = fgetcsv($stream, 0, $this->delimiter(), $this->enclosure(), $this->escape())) !== false) {
            if ($this->skipEmpty() && (empty($row) || $row === [null])) continue;

            $processed = $this->processRow($row, $hasHeader, $headers, $isFirstRow);

            if ($processed === null) continue;

            yield $processed;
        }
    }

    /*----------------------------------------*
     * Process
     *----------------------------------------*/

    /**
     * Process CSV row
     *
     * @param array $row
     * @param bool $hasHeader
     * @param array|null &$headers
     * @param bool &$isFirstRow
     * @return array|null
     */
    protected function processRow(array $row, bool $hasHeader, array|null &$headers, bool &$isFirstRow): array|null
    {
        if ($this->trimValues()) $row = array_map("trim", $row);

        if ($this->encoding() !== "UTF-8") $row = array_map([$this, "convertEncoding"], $row);

        if (!$hasHeader) return $row;

        if ($isFirstRow) {
            $headers = !empty($this->headers) ? $this->headers : $row;

            $isFirstRow = false;

            return null;
        }

        if ($headers === null) return $row;

        $headerCount = count($headers);
        $row = array_pad($row, $headerCount, null);
        $row = array_slice($row, 0, $headerCount);

        return array_combine($headers, $row);
    }
}
