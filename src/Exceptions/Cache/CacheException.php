<?php

namespace Spark\Exceptions\Cache;

use Exception;

/**
 * Cache Exception
 *
 * @package Spark\Exceptions\Cache
 */
class CacheException extends Exception
{
    /**
     * Additional context data for debugging
     *
     * @var array
     */
    protected array $context = [];

    /**
     * Set context data
     *
     * @param array $context
     * @return static
     */
    public function setContext(array $context): static
    {
        $this->context = $context;
        return $this;
    }

    /**
     * Get context data
     *
     * @return array
     */
    public function context(): array
    {
        return $this->context;
    }
}
