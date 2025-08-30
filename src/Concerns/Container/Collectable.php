<?php

declare(strict_types=1);

namespace Spark\Concerns\Container;

/**
 * Collectable
 *
 * @package Spark\Concerns\Container
 *
 * @method array<int, string> mergeKeys(string|array<int, string> ...$args)
 * @method array<string, mixed> toArray()
 * @method array<string, mixed> properties()
 */
trait Collectable
{
    /**
     * Get count
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->toArray());
    }

    /**
     * Get all keys
     *
     * @return array<int, string>
     */
    public function keys(): array
    {
        return array_keys($this->toArray());
    }

    /**
     * Get all values
     *
     * @return array<int, mixed>
     */
    public function values(): array
    {
        return array_values($this->toArray());
    }

    /**
     * Get only specified properties
     *
     * @param string|array<int, string> ...$keys
     * @return array<string, mixed>
     */
    public function only(string|array ...$keys): array
    {
        $keys = $this->mergeKeys(...$keys);

        return array_filter(
            $this->toArray(),
            fn(string $key): bool => in_array($key, $keys, true),
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * Get all properties except specified ones
     *
     * @param string|array<int, string> ...$keys
     * @return array<string, mixed>
     */
    public function except(string|array ...$keys): array
    {
        $keys = $this->mergeKeys(...$keys);

        return array_filter(
            $this->toArray(),
            fn(string $key): bool => !in_array($key, $keys, true),
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * Get all data
     *
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return array_merge($this->toArray(), $this->properties());
    }
}
