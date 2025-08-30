<?php

declare(strict_types=1);

namespace Spark\Exceptions\File;

use Spark\Exceptions\File\OperationException;

/**
 * Lock Exception
 *
 * @package Spark\Exceptions\File
 */
class LockException extends OperationException
{
    /**
     * File path
     *
     * @var string
     */
    protected string $path;

    /**
     * Lock operation
     *
     * @var string
     */
    protected string $operation;

    /**
     * Constructor
     *
     * @param string $path
     * @param string $operation
     */
    public function __construct(string $path, string $operation)
    {
        $this->path      = $path;
        $this->operation = $operation;

        parent::__construct("Failed to {$operation} file: \"{$path}\"");
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
     * Get operation
     *
     * @return string
     */
    public function operation(): string
    {
        return $this->operation;
    }
}
