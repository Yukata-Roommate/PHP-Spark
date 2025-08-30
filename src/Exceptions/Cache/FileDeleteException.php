<?php

declare(strict_types=1);

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\StorageException;

use Throwable;

/**
 * File Delete Exception
 *
 * @package Spark\Exceptions\Cache
 */
class FileDeleteException extends StorageException
{
    /**
     * File path failed to delete
     *
     * @var string
     */
    protected string $filePath;

    /**
     * Constructor
     *
     * @param string $filePath
     * @param Throwable|null $previous
     */
    public function __construct(string $filePath, Throwable|null $previous = null)
    {
        $this->filePath = $filePath;

        parent::__construct("Failed to delete cache file: {$filePath}", 0, $previous);
    }

    /**
     * Get file path
     *
     * @return string
     */
    public function filePath(): string
    {
        return $this->filePath;
    }
}
