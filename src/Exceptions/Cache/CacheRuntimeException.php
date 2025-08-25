<?php

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\CacheException;

/**
 * Cache Runtime Exception
 *
 * @package Spark\Exceptions\Cache
 */
class CacheRuntimeException extends CacheException
{
    /**
     * Whether this error is potentially retryable
     *
     * @var bool
     */
    protected bool $retryable = true;

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
