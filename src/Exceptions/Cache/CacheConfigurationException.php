<?php

namespace Spark\Exceptions\Cache;

/**
 * Cache Configuration Exception
 *
 * @package Spark\Exceptions\Cache
 */
class CacheConfigurationException extends CacheException
{
    /**
     * Configuration errors are not retryable
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
