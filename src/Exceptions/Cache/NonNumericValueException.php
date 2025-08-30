<?php

declare(strict_types=1);

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\DataException;

/**
 * Non-Numeric Value Exception
 *
 * @package Spark\Exceptions\Cache
 */
class NonNumericValueException extends DataException
{
    /**
     * Corrupted cache key
     *
     * @var string
     */
    protected string $key;

    /**
     * Actual type of value
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

        parent::__construct("Expected numeric value for key \"{$key}\", got {$actualType}");
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
