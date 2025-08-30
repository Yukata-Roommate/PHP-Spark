<?php

declare(strict_types=1);

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\DataException;

/**
 * Invalid Data Structure Exception
 *
 * @package Spark\Exceptions\Cache
 */
class InvalidDataStructureException extends DataException
{
    /**
     * Corrupted cache key
     *
     * @var string
     */
    protected string $key;

    /**
     * Actual type received
     *
     * @var string
     */
    protected string $actualType;

    /**
     * Constructor
     *
     * @param string $key
     * @param string $actualType
     */
    public function __construct(string $key, string $actualType)
    {
        $this->key        = $key;
        $this->actualType = $actualType;

        parent::__construct("Invalid data structure for key \"{$key}\": expected array, got {$actualType}");
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
     * Get actual type
     *
     * @return string
     */
    public function actualType(): string
    {
        return $this->actualType;
    }
}
