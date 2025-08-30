<?php

declare(strict_types=1);

namespace Spark\Exceptions\File;

use Spark\Exceptions\File\OperationException;

/**
 * Delete Exception
 *
 * @package Spark\Exceptions\File
 */
class DeleteException extends OperationException
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
     * @param string $reason
     */
    public function __construct(string $path, string $reason)
    {
        $this->path = $path;

        parent::__construct("Failed to delete file: \"{$path}\": {$reason}");
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
