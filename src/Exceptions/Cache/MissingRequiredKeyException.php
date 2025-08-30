<?php

declare(strict_types=1);

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\DataException;

/**
 * Missing Required Key Exception
 *
 * @package Spark\Exceptions\Cache
 */
class MissingRequiredKeyException extends DataException
{
    /**
     * Corrupted cache key
     *
     * @var string
     */
    protected string $key;

    /**
     * Missing required key in data structure
     *
     * @var string
     */
    protected string $missingKey;

    /**
     * Constructor
     *
     * @param string $key
     * @param string $missingKey
     */
    public function __construct(string $key, string $missingKey)
    {
        $this->key        = $key;
        $this->missingKey = $missingKey;

        parent::__construct("Missing required key \"{$missingKey}\" in cache data for key \"{$key}\"");
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
     * Get missing required key
     *
     * @return string
     */
    public function missingKey(): string
    {
        return $this->missingKey;
    }
}
