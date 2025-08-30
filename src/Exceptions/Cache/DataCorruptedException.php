<?php

declare(strict_types=1);

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\DataException;

/**
 * Data Corrupted Exception
 *
 * @package Spark\Exceptions\Cache
 */
class DataCorruptedException extends DataException
{
    /**
     * Corrupted cache key
     *
     * @var string
     */
    protected string $key;

    /**
     * Reason for corruption
     *
     * @var string
     */
    protected string $reason;

    /**
     * Constructor
     *
     * @param string $key
     * @param string $reason
     */
    public function __construct(string $key, string $reason)
    {
        $this->key    = $key;
        $this->reason = $reason;

        parent::__construct("Cache data corrupted for key \"{$key}\": {$reason}");
    }

    /**
     * Get corrupted cache key
     *
     * @return string
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * Get corruption reason
     *
     * @return string
     */
    public function reason(): string
    {
        return $this->reason;
    }
}
