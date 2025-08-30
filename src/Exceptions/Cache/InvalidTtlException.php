<?php

declare(strict_types=1);

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\ConfigurationException;

/**
 * Invalid TTL Exception
 *
 * @package Spark\Exceptions\Cache
 */
class InvalidTtlException extends ConfigurationException
{
    /**
     * Invalid TTL value
     *
     * @var int
     */
    protected int $ttl;

    /**
     * Constructor
     *
     * @param int $ttl
     */
    public function __construct(int $ttl)
    {
        $this->ttl = $ttl;

        parent::__construct("TTL must be non-negative, got {$ttl}");
    }

    /**
     * Get invalid TTL value
     *
     * @return int
     */
    public function ttl(): int
    {
        return $this->ttl;
    }
}
