<?php

declare(strict_types=1);

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\StorageException;

use Throwable;

/**
 * Directory Create Exception
 *
 * @package Spark\Exceptions\Cache
 */
class DirectoryCreateException extends StorageException
{
    /**
     * Directory failed to create
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

        parent::__construct("Failed to create cache directory: {$directory}", 0, $previous);
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
