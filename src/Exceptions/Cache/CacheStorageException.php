<?php

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\CacheRuntimeException;

use Throwable;

/**
 * Cache Storage Exception
 *
 * @package Spark\Exceptions\Cache
 */
class CacheStorageException extends CacheRuntimeException
{
    /**
     * Storage operation that failed
     *
     * @var string
     */
    protected string $operation;

    /**
     * Path or resource that caused the error
     *
     * @var string|null
     */
    protected string|null $path;

    /**
     * Constructor
     *
     * @param string $operation
     * @param string $details
     * @param string|null $path
     * @param Throwable|null $previous
     */
    public function __construct(
        string $operation,
        string $details,
        string|null $path = null,
        Throwable|null $previous = null
    ) {
        $this->operation = $operation;
        $this->path      = $path;

        $message = "Cache storage operation \"$operation\" failed: $details";

        if ($path !== null) $message .= " (path: $path)";

        parent::__construct($message, 0, $previous);
    }

    /**
     * Get the failed operation name
     *
     * @return string
     */
    public function operation(): string
    {
        return $this->operation;
    }

    /**
     * Get the path or resource
     *
     * @return string|null
     */
    public function path(): string|null
    {
        return $this->path;
    }
}
