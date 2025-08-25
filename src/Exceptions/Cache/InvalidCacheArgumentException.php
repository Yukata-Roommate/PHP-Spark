<?php

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\CacheException;

/**
 * Invalid Cache Argument Exception
 *
 * @package Spark\Exceptions\Cache
 */
class InvalidCacheArgumentException extends CacheException
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * constructor
     *
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
