<?php

declare(strict_types=1);

namespace Spark\Exceptions\File;

use Spark\Exceptions\File\DataException;

/**
 * Encoding Exception
 *
 * @package Spark\Exceptions\File
 */
class EncodingException extends DataException
{
    /**
     * File path
     *
     * @var string
     */
    protected string $path;

    /**
     * Source encoding
     *
     * @var string
     */
    protected string $sourceEncoding;

    /**
     * Target encoding
     *
     * @var string
     */
    protected string $targetEncoding;

    /**
     * Constructor
     *
     * @param string $path
     * @param string $sourceEncoding
     * @param string $targetEncoding
     */
    public function __construct(string $path, string $sourceEncoding, string $targetEncoding)
    {
        $this->path           = $path;
        $this->sourceEncoding = $sourceEncoding;
        $this->targetEncoding = $targetEncoding;

        parent::__construct("Failed to convert encoding for \"{$path}\" from {$sourceEncoding} to {$targetEncoding}");
    }

    /**
     * Get file path
     *
     * @return string
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * Get source encoding
     *
     * @return string
     */
    public function sourceEncoding(): string
    {
        return $this->sourceEncoding;
    }

    /**
     * Get target encoding
     *
     * @return string
     */
    public function targetEncoding(): string
    {
        return $this->targetEncoding;
    }
}
