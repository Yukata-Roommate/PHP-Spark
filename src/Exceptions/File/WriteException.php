<?php

declare(strict_types=1);

namespace Spark\Exceptions\File;

use Spark\Exceptions\File\OperationException;

/**
 * Write Exception
 *
 * @package Spark\Exceptions\File
 */
class WriteException extends OperationException
{
    /**
     * File path
     *
     * @var string
     */
    protected string $path;

    /**
     * Constructor
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;

        parent::__construct("Failed to write to file: \"{$path}\"");
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
}
