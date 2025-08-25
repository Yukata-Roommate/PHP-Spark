<?php

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\CacheException;

/**
 * Cache Capacity Exceeded Exception
 *
 * @package Spark\Exceptions\Cache
 */
class CacheCapacityExceededException extends CacheException
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
