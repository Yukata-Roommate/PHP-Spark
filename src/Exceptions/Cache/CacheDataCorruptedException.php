<?php

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\CacheDataException;

use Throwable;

/**
 * Cache Data Corrupted Exception
 *
 * @package Spark\Exceptions\Cache
 */
class CacheDataCorruptedException extends CacheDataException
{
    /**
     * The corrupted cache key
     *
     * @var string|null
     */
    protected string|null $key;

    /**
     * Expected data structure
     *
     * @var string|null
     */
    protected string|null $expectedStructure;

    /**
     * Constructor
     *
     * @param string $message
     * @param string|null $key
     * @param string|null $expectedStructure
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message,
        string|null $key = null,
        string|null $expectedStructure = null,
        Throwable|null $previous = null
    ) {
        $this->key               = $key;
        $this->expectedStructure = $expectedStructure;

        if ($key !== null) $message = "Cache data corrupted for key \"$key\": $message";

        parent::__construct($message, 0, $previous);
    }

    /**
     * Get the corrupted cache key
     *
     * @return string|null
     */
    public function key(): string|null
    {
        return $this->key;
    }

    /**
     * Get the expected data structure description
     *
     * @return string|null
     */
    public function expectedStructure(): string|null
    {
        return $this->expectedStructure;
    }
}
