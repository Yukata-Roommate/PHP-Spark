<?php

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\CacheException;

/**
 * Cache Data Exception
 *
 * @package Spark\Exceptions\Cache
 */
class CacheDataException extends CacheException
{
    /**
     * These errors are typically not retryable
     */
    protected bool $retryable = false;

    /**
     * Check if the operation can be retried
     *
     * @return bool
     */
    public function isRetryable(): bool
    {
        return $this->retryable;
    }
}
