<?php

declare(strict_types=1);

namespace Spark\File;

use Spark\Contracts\File\CsvWriter as CsvWriterContract;
use Spark\Foundation\File\Writer;

use Spark\Exceptions\File\EncodingException;

/**
 * CSV File Writer
 *
 * @package Spark\File
 */
class CsvWriter extends Writer implements CsvWriterContract
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
     * Whether to write header
     *
     * @var bool
     */
    protected bool $hasHeader = true;

    /**
     * CSV headers
     *
     * @var array<string>
     */
    protected array $headers = [];

    /**
     * Header written flag
     *
     * @var bool
     */
    protected bool $headerWritten = false;

    /**
     * {@inheritDoc}
     */
    public function setHasHeader(bool $hasHeader): static
    {
        $this->hasHeader = $hasHeader;

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
    public function setHeaders(array $headers): static
    {
        $this->headers       = $headers;
        $this->headerWritten = false;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function headers(): array
    {
        return $this->headers;
    }

    /*----------------------------------------*
     * BOM
     *----------------------------------------*/

    /**
     * Whether to use BOM
     *
     * @var bool
     */
    protected bool $useBom = false;

    /**
     * {@inheritDoc}
     */
    public function setUseBom(bool $useBom): static
    {
        $this->useBom = $useBom;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function useBom(): bool
    {
        return $this->useBom;
    }

    /*----------------------------------------*
     * Sanitize
     *----------------------------------------*/

    /**
     * Whether to sanitize values for CSV injection
     *
     * @var bool
     */
    protected bool $sanitize = false;

    /**
     * {@inheritDoc}
     */
    public function setSanitize(bool $sanitize): static
    {
        $this->sanitize = $sanitize;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function sanitize(): bool
    {
        return $this->sanitize;
    }

    /*----------------------------------------*
     * Persistence
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    protected function format(mixed $data): string
    {
        return match (true) {
            is_null($data)   => "",
            is_bool($data)   => $data ? "1" : "0",
            is_array($data)  => json_encode($data),
            is_object($data) => json_encode($data),

            default => (string) $data
        };
    }

    /**
     * {@inheritDoc}
     *
     * @throws \Spark\Exceptions\File\WriteException
     * @throws \Spark\Exceptions\File\EncodingException
     */
    #[\Override]
    protected function processContent($handle, array $data, bool $append): void
    {
        if ($append && $this->exists() && $this->size() > 0) $this->headerWritten = true;

        if ($this->useBom && !$append && !$this->headerWritten && $this->encoding === "UTF-8") fwrite($handle, "\xEF\xBB\xBF");

        if ($this->hasHeader && !$this->headerWritten && !empty($this->headers)) {
            fputcsv($handle, $this->headers, $this->delimiter, $this->enclosure, $this->escape);

            $this->headerWritten = true;
        }

        foreach ($data as $row) {
            $this->writeCsvLine($handle, $row);
        }
    }

    /**
     * Write CSV line
     *
     * @param resource $handle
     * @param mixed $row
     * @return void
     * @throws \Spark\Exceptions\File\EncodingException
     */
    protected function writeCsvLine($handle, mixed $row): void
    {
        $csvRow = $this->prepareCsvRow($row);

        if ($this->sanitize) $csvRow = array_map(fn($value) => $this->sanitizeValue($value), $csvRow);

        if ($this->encoding !== "UTF-8") {
            $csvRow = array_map(function ($value) {
                $converted = @mb_convert_encoding((string)$value, $this->encoding, "UTF-8");

                if ($converted === false) throw new EncodingException($this->path, "UTF-8", $this->encoding);

                return $converted;
            }, $csvRow);
        }

        fputcsv($handle, $csvRow, $this->delimiter, $this->enclosure, $this->escape);
    }

    /**
     * Prepare row for CSV
     *
     * @param mixed $row
     * @return array
     */
    protected function prepareCsvRow(mixed $row): array
    {
        if (!is_array($row)) return [$this->format($row)];

        if (!empty($this->headers) && array_keys($row) !== range(0, count($row) - 1)) {
            $prepared = [];

            foreach ($this->headers as $header) {
                $prepared[] = $this->format($row[$header] ?? null);
            }

            return $prepared;
        }

        return array_map(fn($value) => $this->format($value), $row);
    }

    /**
     * Sanitize value for CSV injection
     *
     * @param string $value
     * @return string
     */
    protected function sanitizeValue(string $value): string
    {
        if ($value === "") return $value;

        $firstChar = $value[0];

        if (in_array($firstChar, ["=", "+", "-", "@", "\t", "\r"])) return "'" . $value;

        return $value;
    }
}
