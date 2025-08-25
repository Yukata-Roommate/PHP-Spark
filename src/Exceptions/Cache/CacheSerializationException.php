<?php

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\CacheDataException;

use Throwable;

/**
 * Cache Serialization Exception
 *
 * @package Spark\Exceptions\Cache
 */
class CacheSerializationException extends CacheDataException
{
    /**
     * The cache key
     *
     * @var string
     */
    protected string $key;

    /**
     * The operation that failed (serialize/unserialize)
     *
     * @var string
     */
    protected string $operation;

    /**
     * Constructor
     *
     * @param string $key
     * @param string $operation
     * @param Throwable|null $previous
     */
    public function __construct(
        string $key,
        string $operation = "unserialize",
        Throwable|null $previous = null
    ) {
        $this->key       = $key;
        $this->operation = $operation;

        parent::__construct(
            "Failed to $operation cache data for key: $key",
            0,
            $previous
        );
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
     * Get the failed operation
     *
     * @return string
     */
    public function operation(): string
    {
        return $this->operation;
    }
}
