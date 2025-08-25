<?php

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\CacheRuntimeException;

/**
 * Cache Key Not Found Exception
 *
 * @package Spark\Exceptions\Cache
 */
class CacheKeyNotFoundException extends CacheRuntimeException
{
    /**
     * The cache key that was not found
     *
     * @var string
     */
    protected string $key;

    /**
     * Constructor
     *
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;

        parent::__construct("Cache key \"$key\" does not exist.");
    }

    /**
     * Get the missing cache key
     *
     * @return string
     */
    public function key(): string
    {
        return $this->key;
    }
}
