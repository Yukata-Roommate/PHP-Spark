<?php

declare(strict_types=1);

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\RuntimeException;

/**
 * Key Expired Exception
 *
 * @package Spark\Exceptions\Cache
 */
class KeyExpiredException extends RuntimeException
{
    /**
     * Expired cache key
     *
     * @var string
     */
    protected string $key;

    /**
     * When key expired (Unix timestamp)
     *
     * @var int
     */
    protected int $expiredAt;

    /**
     * Constructor
     *
     * @param string $key
     * @param int $expiredAt
     */
    public function __construct(string $key, int $expiredAt)
    {
        $this->key       = $key;
        $this->expiredAt = $expiredAt;

        parent::__construct(sprintf("Cache key \"%s\" expired at %s", $key, date("Y-m-d H:i:s", $expiredAt)));
    }

    /**
     * Get expired cache key
     *
     * @return string
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * Get expiration timestamp
     *
     * @return int
     */
    public function expiredAt(): int
    {
        return $this->expiredAt;
    }
}
