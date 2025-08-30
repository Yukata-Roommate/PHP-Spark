<?php

declare(strict_types=1);

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\RuntimeException;

/**
 * Key Not Found Exception
 *
 * @package Spark\Exceptions\Cache
 */
class KeyNotFoundException extends RuntimeException
{
    /**
     * Cache key was not found
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

        parent::__construct("Cache key \"{$key}\" not found");
    }

    /**
     * Get missing cache key
     *
     * @return string
     */
    public function key(): string
    {
        return $this->key;
    }
}
