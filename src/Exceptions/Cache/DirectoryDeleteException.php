<?php

declare(strict_types=1);

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\StorageException;

use Throwable;

/**
 * Directory Delete Exception
 *
 * @package Spark\Exceptions\Cache
 */
class DirectoryDeleteException extends StorageException
{
    /**
     * Directory failed to delete
     *
     * @var string
     */
    protected string $directory;

    /**
     * Constructor
     *
     * @param string $directory
     * @param Throwable|null $previous
     */
    public function __construct(string $directory, Throwable|null $previous = null)
    {
        $this->directory = $directory;

        parent::__construct("Failed to delete cache directory: {$directory}", 0, $previous);
    }

    /**
     * Get directory path
     *
     * @return string
     */
    public function directory(): string
    {
        return $this->directory;
    }
}
