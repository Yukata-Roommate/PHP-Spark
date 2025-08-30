<?php

declare(strict_types=1);

namespace Spark\File;

use Spark\Contracts\File\TextWriter as TextWriterContract;
use Spark\Foundation\File\Writer;

/**
 * Text File Writer
 *
 * @package Spark\File
 */
class TextWriter extends Writer implements TextWriterContract
{
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
     * Persistence
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    protected function format(mixed $data): string
    {
        $formatted = match (true) {
            is_null($data)   => "",
            is_bool($data)   => $data ? "true" : "false",
            is_array($data)  => json_encode($data),
            is_object($data) => json_encode($data),

            default => (string) $data
        };

        return $formatted . $this->newLine;
    }

    /**
     * {@inheritDoc}
     */
    #[\Override]
    protected function processContent($handle, array $data, bool $append): void
    {
        if ($this->useBom && !$append && $this->encoding === "UTF-8") fwrite($handle, "\xEF\xBB\xBF");

        parent::processContent($handle, $data, $append);
    }
}
