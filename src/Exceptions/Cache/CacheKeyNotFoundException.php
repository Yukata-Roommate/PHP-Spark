<?php

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\CacheException;

/**
 * Cache Key Not Found Exception
 *
 * @package Spark\Exceptions\Cache
 */
class CacheKeyNotFoundException extends CacheException
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
        parent::__construct("Cache key \"$key\" does not exist.");
    }
}
