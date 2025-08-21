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
     * load cache value
     *
     * @param string $key
     * @return mixed
     */
    public function load(string $key): mixed;

    /**
     * safely load cache value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function safeLoad(string $key, mixed $default = null): mixed;

    /**
     * load multiple cache values
     *
     * @param array $keys
     * @return array
     */
    public function loadMany(array $keys): array;

    /**
     * get cache value ensure exists
     *
     * @param string $key
     * @param callable $callback
     * @param int|null $ttl
     * @return mixed
     */
    public function remember(string $key, callable $callback, int|null $ttl = null): mixed;

    /**
     * whether exists cache value
     *
     * @param string $key
     * @return bool
     */
    public function exists(string $key): bool;

    /*----------------------------------------*
     * Save
     *----------------------------------------*/

    /**
     * save cache value
     *
     * @param string $key
     * @param mixed $value
     * @param int|null $ttl
     * @return array
     */
    public function save(string $key, mixed $value, int|null $ttl = null): array;

    /**
     * save multiple cache values
     *
     * @param array $values
     * @param int|null $ttl
     * @return int
     */
    public function saveMany(array $values, int|null $ttl = null): int;

    /**
     * increment numeric cache value
     *
     * @param string $key
     * @param int $step
     * @return int
     */
    public function increment(string $key, int $step = 1): int;

    /**
     * decrement numeric cache value
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
     * delete cache value
     *
     * @param string $key
     * @return void
     */
    public function delete(string $key): void;

    /**
     * clear all cache values
     *
     * @return void
     */
    public function clear(): void;

    /**
     * clean expired cache values
     *
     * @return int
     */
    public function clean(): int;

    /**
     * delete multiple cache values
     *
     * @param array $keys
     * @return int
     */
    public function deleteMany(array $keys): int;

    /*----------------------------------------*
     * TTL
     *----------------------------------------*/

    /**
     * set default ttl
     *
     * @param int|null $ttl
     * @return void
     */
    public function setDefaultTtl(int|null $ttl): void;

    /**
     * get default ttl
     *
     * @return int|null
     */
    public function defaultTtl(): int|null;
}
