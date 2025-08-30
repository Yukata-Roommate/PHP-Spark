<?php

declare(strict_types=1);

namespace Spark\Contracts\Cache;

/**
 * Cache Driver Contract
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
     * @throws \Spark\Exceptions\Cache\KeyNotFoundException
     * @throws \Spark\Exceptions\Cache\KeyExpiredException
     * @throws \Spark\Exceptions\Cache\DataCorruptedException
     * @throws \Spark\Exceptions\Cache\InvalidDataStructureException
     * @throws \Spark\Exceptions\Cache\MissingRequiredKeyException
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
     * @param array<string> $keys
     * @return array<string, mixed>
     */
    public function loadMany(array $keys): array;

    /**
     * Get cache value or compute and store if missing
     *
     * @param string $key
     * @param callable $callback
     * @param int|null $ttl
     * @return mixed
     * @throws \Spark\Exceptions\Cache\CacheException
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
     * @throws \Spark\Exceptions\Cache\InvalidTtlException
     * @throws \Spark\Exceptions\Cache\MemoryLimitExceededException
     * @throws \Spark\Exceptions\Cache\ItemsLimitExceededException
     * @throws \Spark\Exceptions\Cache\FileWriteException
     * @throws \Spark\Exceptions\Cache\DirectoryCreateException
     */
    public function save(string $key, mixed $value, int|null $ttl = null): bool;

    /**
     * Save multiple cache values
     *
     * @param array<string, mixed> $values
     * @param int|null $ttl
     * @return int Number of successfully saved items
     */
    public function saveMany(array $values, int|null $ttl = null): int;

    /**
     * Increment numeric cache value
     *
     * @param string $key
     * @param int $step
     * @return int
     * @throws \Spark\Exceptions\Cache\NonNumericValueException
     */
    public function increment(string $key, int $step = 1): int;

    /**
     * Decrement numeric cache value
     *
     * @param string $key
     * @param int $step
     * @return int
     * @throws \Spark\Exceptions\Cache\NonNumericValueException
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
     * @throws \Spark\Exceptions\Cache\FileDeleteException
     */
    public function delete(string $key): void;

    /**
     * Clear all cache values
     *
     * @return void
     * @throws \Spark\Exceptions\Cache\FileDeleteException
     * @throws \Spark\Exceptions\Cache\DirectoryDeleteException
     */
    public function clear(): void;

    /**
     * Clean expired cache values
     *
     * @return int Number of cleaned entries
     */
    public function clean(): int;

    /**
     * Delete multiple cache values
     *
     * @param array<string> $keys
     * @return int Number of deleted entries
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
     * @throws \Spark\Exceptions\Cache\InvalidTtlException
     */
    public function setDefaultTtl(int|null $ttl): void;

    /**
     * Get default TTL
     *
     * @return int|null
     */
    public function defaultTtl(): int|null;

    /*----------------------------------------*
     * Count
     *----------------------------------------*/

    /**
     * Get cache items count
     *
     * @return int
     */
    public function count(): int;
}
