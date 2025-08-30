<?php

declare(strict_types=1);

namespace Spark\Exceptions;

use Exception;

/**
 * Spark Exception
 *
 * @package Spark\Exceptions
 */
abstract class SparkException extends Exception
{
    /*----------------------------------------*
     * Context
     *----------------------------------------*/

    /**
     * Additional context data for debugging
     *
     * @var array
     */
    protected array $context = [];

    /**
     * Get context data
     *
     * @return array
     */
    public function context(): array
    {
        return $this->context;
    }

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
     * Add context item
     *
     * @param string $key
     * @param mixed $value
     * @return static
     */
    public function addContext(string $key, mixed $value): static
    {
        $this->context[$key] = $value;

        return $this;
    }

    /**
     * Merge multiple context items
     *
     * @param array<string, mixed> $context
     * @return static
     */
    public function mergeContext(array $context): static
    {
        $this->context = array_merge($this->context, $context);

        return $this;
    }

    /*----------------------------------------*
     * Retryable
     *----------------------------------------*/

    /**
     * Whether operation can be retried
     *
     * @var bool
     */
    protected bool $retryable = true;

    /**
     * Check if operation can be retried
     *
     * @return bool
     */
    public function isRetryable(): bool
    {
        return $this->retryable;
    }
}
