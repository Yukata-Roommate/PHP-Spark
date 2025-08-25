<?php

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\CacheRuntimeException;

/**
 * Cache Key Expired Exception
 *
 * @package Spark\Exceptions\Cache
 */
class CacheKeyExpiredException extends CacheRuntimeException
{
    /**
     * The expired cache key
     *
     * @var string
     */
    protected string $key;

    /**
     * When the key expired (Unix timestamp)
     *
     * @var int|null
     */
    protected int|null $expiredAt;

    /**
     * Constructor
     *
     * @param string $key
     * @param int|null $expiredAt
     */
    public function __construct(string $key, int|null $expiredAt = null)
    {
        $this->key       = $key;
        $this->expiredAt = $expiredAt;

        $message = "Cache key \"$key\" has expired";

        if ($expiredAt !== null) $message .= " (expired at: " . date("Y-m-d H:i:s", $expiredAt) . ")";

        parent::__construct($message);
    }

    /**
     * Get the expired cache key
     *
     * @return string
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * Get the expiration timestamp
     *
     * @return int|null
     */
    public function expiredAt(): int|null
    {
        return $this->expiredAt;
    }
}
