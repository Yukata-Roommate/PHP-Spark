<?php

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\CacheRuntimeException;

/**
 * Cache Lock Exception
 *
 * @package Spark\Exceptions\Cache
 */
class CacheLockException extends CacheRuntimeException
{
    /**
     * The cache key that could not be locked
     *
     * @var string
     */
    protected string $key;

    /**
     * Lock timeout in seconds
     *
     * @var int|null
     */
    protected int|null $timeout;

    /**
     * Constructor
     *
     * @param string $key
     * @param string $reason
     * @param int|null $timeout
     */
    public function __construct(
        string $key,
        string $reason = "Could not acquire lock",
        int|null $timeout = null
    ) {
        $this->key = $key;
        $this->timeout = $timeout;

        $message = "Lock error for key \"$key\": $reason";

        if ($timeout !== null) $message .= " (timeout: {$timeout}s)";

        parent::__construct($message);
    }

    /**
     * Get the cache key
     *
     * @return string
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * Get the lock timeout
     *
     * @return int|null
     */
    public function timeout(): int|null
    {
        return $this->timeout;
    }
}
