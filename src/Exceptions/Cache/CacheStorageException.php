<?php

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\CacheException;

/**
 * Cache Storage Exception
 *
 * @package Spark\Exceptions\Cache
 */
class CacheStorageException extends CacheException
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * constructor
     *
     * @param string $key
     */
    public function __construct(string $operation, string $details)
    {
        parent::__construct("Cache storage operation '$operation' failed: $details");
    }
}
