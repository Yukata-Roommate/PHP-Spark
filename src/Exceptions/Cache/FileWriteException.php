<?php

declare(strict_types=1);

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\StorageException;

use Throwable;

/**
 * File Write Exception
 *
 * @package Spark\Exceptions\Cache
 */
class FileWriteException extends StorageException
{
    /**
     * File path failed to write
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

        parent::__construct("Failed to write cache file: {$filePath}", 0, $previous);
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
