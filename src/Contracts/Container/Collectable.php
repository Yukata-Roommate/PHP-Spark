<?php

declare(strict_types=1);

namespace Spark\Contracts\Container;

/**
 * Container Collectable Contract
 *
 * @package Spark\Contracts\Container
 */
interface Collectable extends \Countable
{
    /**
     * Get count
     *
     * @return int
     */
    public function count(): int;

    /**
     * Get all keys
     *
     * @return array<int, string>
     */
    public function keys(): array;

    /**
     * Get all values
     *
     * @return array<int, mixed>
     */
    public function values(): array;

    /**
     * Get only specified properties
     *
     * @param string|array<int, string> ...$keys
     * @return array<string, mixed>
     */
    public function only(string|array ...$keys): array;

    /**
     * Get all properties except specified ones
     *
     * @param string|array<int, string> ...$keys
     * @return array<string, mixed>
     */
    public function except(string|array ...$keys): array;

    /**
     * Convert to array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;

    /**
     * Get all data
     *
     * @return array<string, mixed>
     */
    public function all(): array;
}
