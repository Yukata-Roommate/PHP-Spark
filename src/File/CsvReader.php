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
            if (empty($row) || $row === [null]) continue;

            $processed = $this->processRow($row, $hasHeader, $headers, $isFirstRow);

            if ($processed === false) continue;

            yield $processed;
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
            $hasHeader  = $this->hasHeader();
            $headers    = null;
            $isFirstRow = true;

            for ($i = 1; $i < $start; $i++) {
                if (fgets($stream) === false) break;
            }

            while (($row = fgetcsv($stream, 0, $this->delimiter, $this->enclosure, $this->escape)) !== false) {
                if (empty($row) || $row === [null]) continue;

                $processed = $this->processRow($row, $hasHeader, $headers, $isFirstRow);

                if ($processed !== null) yield $processed;
            }
        } finally {
            fclose($stream);
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

        $combined = array_combine($headers, $row);

        return $combined !== false ? $combined : null;
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

        foreach ($this->rows($start) as $line) {
            $chunk[] = $line;

            if (count($chunk) >= $row) {
                yield $chunk;

                $chunk = [];
            }
        }

        if (count($chunk) > 0) yield $chunk;
    }

    /**
     * iterate through file columns
     *
     * @param array $columns
     * @param int $start
     * @return \Generator
     */
    public function columns(array $columns, int $start = 1): \Generator
    {
        $hasHeader = $this->hasHeader();

        foreach ($this->rows($start) as $row) {
            if ($hasHeader) {
                yield array_intersect_key($row, array_flip($columns));

                continue;
            }

            $filteredRow = [];
            foreach ($columns as $column) {
                if (!array_key_exists($column, $row)) continue;

                $filteredRow[$column] = $row[$column];
            }

            yield $filteredRow;
        }
    }

    /**
     * iterate through file column
     *
     * @param string $column
     * @param int $start
     * @return \Generator
     */
    public function column(string $column, int $start = 1): \Generator
    {
        return $this->columns([$column], $start);
    }

    /**
     * filter rows by callback
     *
     * @param callable $callback
     * @param int $start
     * @return \Generator
     */
    public function filter(callable $callback, int $start = 1): \Generator
    {
        foreach ($this->rows($start) as $row) {
            if (!$callback($row)) continue;

            yield $row;
        }
    }

    /**
     * map rows by callback
     *
     * @param callable $callback
     * @param int $start
     * @return \Generator
     */
    public function map(callable $callback, int $start = 1): \Generator
    {
        foreach ($this->rows($start) as $row) {
            yield $callback($row);
        }
    }

    /**
     * search rows by value
     *
     * @param mixed $value
     * @param string|int|null $column
     * @param int $start
     * @return \Generator
     */
    public function search(mixed $value, string|int|null $column = null, int $start = 1): \Generator
    {
        if ($column !== null) return $this->searchColumn($value, $column, $start);

        foreach ($this->rows($start) as $row) {
            if (!in_array($value, $row, true)) continue;

            yield $row;
        }
    }

    /**
     * search row numbers by value
     *
     * @param mixed $value
     * @param string|int|null $column
     * @param int $start
     * @return \Generator
     */
    public function searchNumbers(mixed $value, string|int|null $column = null, int $start = 1): \Generator
    {
        if ($column !== null) return $this->searchColumnNumbers($value, $column, $start);

        foreach ($this->rows($start) as $rowNumber => $row) {
            if (!in_array($value, $row, true)) continue;

            yield $rowNumber + 1;
        }
    }

    /**
     * search rows by value in specific column
     *
     * @param mixed $value
     * @param string|int $column
     * @param int $start
     * @return \Generator
     */
    public function searchColumn(mixed $value, string|int $column, int $start = 1): \Generator
    {
        foreach ($this->rows($start) as $row) {
            if (!array_key_exists($column, $row)) continue;

            if ($row[$column] !== $value) continue;

            yield $row;
        }
    }

    /**
     * search row numbers by value in specific column
     *
     * @param mixed $value
     * @param string|int $column
     * @param int $start
     * @return \Generator
     */
    public function searchColumnNumbers(mixed $value, string|int $column, int $start = 1): \Generator
    {
        foreach ($this->rows($start) as $rowNumber => $row) {
            if (!array_key_exists($column, $row)) continue;

            if ($row[$column] !== $value) continue;

            yield $rowNumber + 1;
        }
    }

    /*----------------------------------------*
     * Count
     *----------------------------------------*/

    /**
     * count rows
     *
     * @return int
     */
    public function countRows(): int
    {
        $count = 0;

        foreach ($this->rows() as $row) {
            $count++;
        }

        return $count;
    }

    /**
     * count columns
     *
     * @return int
     */
    public function countColumns(): int
    {
        $headers = $this->headers();

        if (!empty($headers)) return count($headers);

        foreach ($this->rows() as $row) {
            return count($row);
        }

        return 0;
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

        if ($row === false || empty($row) || $row === [null]) return [];

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
