<?php

declare(strict_types=1);

namespace Spark\Exceptions\File;

use Spark\Exceptions\File\DataException;

/**
 * JSON Format Exception
 *
 * @package Spark\Exceptions\File
 */
class JsonFormatException extends DataException
{
    /**
     * File path
     *
     * @var string
     */
    protected string $path;

    /**
     * Operation type (encode/decode)
     *
     * @var string
     */
    protected string $operation;

    /**
     * Error message from json_last_error_msg()
     *
     * @var string
     */
    protected string $jsonError;

    /**
     * Constructor
     *
     * @param string $path
     * @param string $operation
     * @param string $jsonError
     */
    public function __construct(string $path, string $operation, string $jsonError)
    {
        $this->path      = $path;
        $this->operation = $operation;
        $this->jsonError = $jsonError;

        parent::__construct("Failed to {$operation} JSON for \"{$path}\": {$jsonError}");
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
     * Get operation type
     *
     * @return string
     */
    public function operation(): string
    {
        return $this->operation;
    }

    /**
     * Get JSON error message
     *
     * @return string
     */
    public function jsonError(): string
    {
        return $this->jsonError;
    }
}
