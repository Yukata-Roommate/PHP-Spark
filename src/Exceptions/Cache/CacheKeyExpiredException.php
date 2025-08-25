<?php

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\CacheException;

/**
 * Cache Key Expired Exception
 *
 * @package Spark\Exceptions\Cache
 */
class CacheKeyExpiredException extends CacheException
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * constructor
     *
     * @param string $key
     */
    public function __construct(string $key)
    {
        parent::__construct("Cache key \"$key\" has expired.");
    }
}
