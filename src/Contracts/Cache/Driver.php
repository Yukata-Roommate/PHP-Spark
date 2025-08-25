<?php

namespace Spark\Contracts\Cache;

/**
 * Driver Contract
 *
 * @package Spark\Contracts\Cache
 */
interface Driver
{
    /*----------------------------------------*
     * Load
     *----------------------------------------*/

    /**
     * Load cache value
     *
     * @param string $key
     * @return mixed
     */
    public function load(string $key): mixed;

    /**
     * Safely load cache value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function safeLoad(string $key, mixed $default = null): mixed;

    /**
     * Load multiple cache values
     *
     * @param array $keys
     * @return array
     */
    public function loadMany(array $keys): array;

    /**
     * Get cache value or compute and store if missing
     *
     * @param string $key
     * @param callable $callback
     * @param int|null $ttl
     * @return mixed
     */
    public function remember(string $key, callable $callback, int|null $ttl = null): mixed;

    /**
     * Check if cache value exists and is valid
     *
     * @param string $key
     * @return bool
     */
    public function exists(string $key): bool;

    /*----------------------------------------*
     * Save
     *----------------------------------------*/

    /**
     * Save cache value
     *
     * @param string $key
     * @param mixed $value
     * @param int|null $ttl
     * @return bool
     */
    public function save(string $key, mixed $value, int|null $ttl = null): bool;

    /**
     * Save multiple cache values
     *
     * @param array $values
     * @param int|null $ttl
     * @return int
     */
    public function saveMany(array $values, int|null $ttl = null): int;

    /**
     * Increment numeric cache value
     *
     * @param string $key
     * @param int $step
     * @return int
     */
    public function increment(string $key, int $step = 1): int;

    /**
     * Decrement numeric cache value
     *
     * @param string $key
     * @param int $step
     * @return int
     */
    public function decrement(string $key, int $step = 1): int;

    /*----------------------------------------*
     * Delete
     *----------------------------------------*/

    /**
     * Delete cache value
     *
     * @param string $key
     * @return void
     */
    public function delete(string $key): void;

    /**
     * Clear all cache values
     *
     * @return void
     */
    public function clear(): void;

    /**
     * Clean expired cache values
     *
     * @return int
     */
    public function clean(): int;

    /**
     * Delete multiple cache values
     *
     * @param array $keys
     * @return int
     */
    public function deleteMany(array $keys): int;

    /*----------------------------------------*
     * TTL
     *----------------------------------------*/

    /**
     * Set default TTL
     *
     * @param int|null $ttl
     * @return void
     */
    public function setDefaultTtl(int|null $ttl): void;

    /**
     * Get default TTL
     *
     * @return int|null
     */
    public function defaultTtl(): int|null;
}
