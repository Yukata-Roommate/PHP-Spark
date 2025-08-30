<?php

declare(strict_types=1);

namespace Spark\Exceptions\Cache;

use Spark\Exceptions\Cache\ConfigurationException;

/**
 * Invalid Memory Limit Exception
 *
 * @package Spark\Exceptions\Cache
 */
class InvalidMemoryLimitException extends ConfigurationException
{
    /**
     * Invalid memory limit value
     *
     * @var int
     */
    protected int $memoryLimit;

    /**
     * Constructor
     *
     * @param int $memoryLimit
     */
    public function __construct(int $memoryLimit)
    {
        $this->memoryLimit = $memoryLimit;

        parent::__construct("Memory limit must be positive, got {$memoryLimit} bytes");
    }

    /**
     * Get invalid memory limit value
     *
     * @return int
     */
    public function memoryLimit(): int
    {
        return $this->memoryLimit;
    }
}
