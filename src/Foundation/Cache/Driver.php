<?php

declare(strict_types=1);

namespace Spark\Foundation\Cache;

use Spark\Contracts\Cache\Driver as DriverContract;

use Spark\Exceptions\Cache\CacheException;
use Spark\Exceptions\Cache\KeyNotFoundException;
use Spark\Exceptions\Cache\KeyExpiredException;
use Spark\Exceptions\Cache\DataCorruptedException;
use Spark\Exceptions\Cache\InvalidDataStructureException;
use Spark\Exceptions\Cache\MissingRequiredKeyException;
use Spark\Exceptions\Cache\InvalidTtlException;
use Spark\Exceptions\Cache\NonNumericValueException;

/**
 * Cache Driver
 *
 * @package Spark\Foundation\Cache
 */
abstract class Driver implements DriverContract
{
    /*----------------------------------------*
     * Load
     *----------------------------------------*/

    /**
     * Check if key exists in storage
     *
     * @param string $key
     * @return bool
     */
    abstract protected function has(string $key): bool;

    /**
     * Read raw data from storage
     *
     * @param string $key
     * @return mixed
     * @throws \Spark\Exceptions\Cache\CacheException
     */
    abstract protected function read(string $key): mixed;

    /**
     * {@inheritDoc}
     */
    public function load(string $key): mixed
    {
        if (!$this->has($key)) throw new KeyNotFoundException($key);

        $data = $this->read($key);

        $validated = $this->ensureDataStructure($data, $key);

        if ($this->isExpired($validated)) {
            $this->delete($key);

            throw new KeyExpiredException($key, $validated["expires_at"]);
        }

        $this->loaded($key, $validated);

        return $validated["value"];
    }

    /**
     * Hook called after successful load
     *
     * @param string $key
     * @param array $data
     * @return void
     */
    protected function loaded(string $key, array &$data): void
    {
        // Override in subclasses if needed
    }

    /**
     * {@inheritDoc}
     */
    public function safeLoad(string $key, mixed $default = null): mixed
    {
        try {
            return $this->load($key);
        } catch (CacheException) {
            return $default;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function loadMany(array $keys): array
    {
        $values = [];

        foreach ($keys as $key) {
            $values[$key] = $this->safeLoad($key);
        }

        return $values;
    }

    /**
     * {@inheritDoc}
     */
    public function remember(string $key, callable $callback, int|null $ttl = null): mixed
    {
        if ($this->exists($key)) return $this->load($key);

        $value = $callback();

        $this->save($key, $value, $ttl);

        return $value;
    }

    /**
     * {@inheritDoc}
     */
    public function exists(string $key): bool
    {
        if (!$this->has($key)) return false;

        try {
            $data = $this->read($key);

            $validated = $this->ensureDataStructure($data, $key);

            if (!$this->isExpired($validated)) return true;

            $this->delete($key);

            return false;
        } catch (CacheException) {
            return false;
        }
    }

    /*----------------------------------------*
     * Save
     *----------------------------------------*/

    /**
     * Write data to storage
     *
     * @param string $key
     * @param array $data
     * @return void
     * @throws \Spark\Exceptions\Cache\CacheException
     */
    abstract protected function write(string $key, array $data): void;

    /**
     * {@inheritDoc}
     */
    public function save(string $key, mixed $value, int|null $ttl = null): bool
    {
        $ttl = $ttl ?? $this->defaultTtl;

        if ($ttl !== null && $ttl < 0) throw new InvalidTtlException($ttl);

        $this->prepareSave($key, $value, $ttl);

        $data = $this->buildDataStructure($value, $ttl);

        $this->write($key, $data);

        $this->saved($key, $data);

        return true;
    }

    /**
     * Hook called before saving
     *
     * @param string $key
     * @param mixed $value
     * @param int|null $ttl
     * @return void
     * @throws \Spark\Exceptions\Cache\CacheException
     */
    protected function prepareSave(string $key, mixed &$value, int|null $ttl = null): void
    {
        // Override in subclasses if needed
    }

    /**
     * Hook called after successful save
     *
     * @param string $key
     * @param array $data
     * @return void
     */
    protected function saved(string $key, array &$data): void
    {
        // Override in subclasses if needed
    }

    /**
     * {@inheritDoc}
     */
    public function saveMany(array $values, int|null $ttl = null): int
    {
        $count = 0;

        foreach ($values as $key => $value) {
            try {
                $this->save($key, $value, $ttl);

                $count++;
            } catch (CacheException) {
                continue;
            }
        }

        return $count;
    }

    /**
     * {@inheritDoc}
     */
    public function increment(string $key, int $step = 1): int
    {
        $value = $this->safeLoad($key, 0);

        if (!is_numeric($value)) throw new NonNumericValueException($key, gettype($value));

        $newValue = (int)$value + $step;

        $this->save($key, $newValue);

        return $newValue;
    }

    /**
     * {@inheritDoc}
     */
    public function decrement(string $key, int $step = 1): int
    {
        return $this->increment($key, -$step);
    }

    /*----------------------------------------*
     * Delete
     *----------------------------------------*/

    /**
     * Remove cache value from storage
     *
     * @param string $key
     * @return void
     * @throws \Spark\Exceptions\Cache\CacheException
     */
    abstract protected function remove(string $key): void;

    /**
     * Flush all cache values from storage
     *
     * @return void
     * @throws \Spark\Exceptions\Cache\CacheException
     */
    abstract protected function flush(): void;

    /**
     * {@inheritDoc}
     */
    abstract public function clean(): int;

    /**
     * {@inheritDoc}
     */
    public function delete(string $key): void
    {
        if (!$this->has($key)) return;

        $this->remove($key);
    }

    /**
     * {@inheritDoc}
     */
    public function clear(): void
    {
        $this->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function deleteMany(array $keys): int
    {
        $count = 0;

        foreach ($keys as $key) {
            try {
                $this->delete($key);

                $count++;
            } catch (CacheException) {
                continue;
            }
        }

        return $count;
    }

    /*----------------------------------------*
     * Data Structure
     *----------------------------------------*/

    /**
     * Ensure data structure is valid
     *
     * @param mixed $data
     * @param string $key
     * @return array
     * @throws \Spark\Exceptions\Cache\InvalidDataStructureException
     * @throws \Spark\Exceptions\Cache\MissingRequiredKeyException
     */
    protected function ensureDataStructure(mixed $data, string $key): array
    {
        if (!is_array($data)) throw new InvalidDataStructureException($key, gettype($data));

        $requiredKeys = ["value", "created_at", "expires_at", "metadata"];

        foreach ($requiredKeys as $requiredKey) {
            if (!array_key_exists($requiredKey, $data)) throw new MissingRequiredKeyException($key, $requiredKey);
        }

        return $data;
    }

    /**
     * Validate serialized data integrity
     *
     * @param mixed $data
     * @param string $key
     * @return mixed
     * @throws \Spark\Exceptions\Cache\DataCorruptedException
     */
    protected function validateSerializedData(mixed $data, string $key): mixed
    {
        if ($data === false) throw new DataCorruptedException($key, "Failed to unserialize data");

        return $data;
    }

    /**
     * Build data structure for storage
     *
     * @param mixed $value
     * @param int|null $ttl
     * @return array
     */
    protected function buildDataStructure(mixed $value, int|null $ttl = null): array
    {
        $now = time();

        return [
            "value"      => $value,
            "created_at" => $now,
            "expires_at" => $this->buildExpiresAt($now, $ttl),
            "metadata"   => $this->buildMetadata($value)
        ];
    }

    /**
     * Calculate expiration timestamp
     *
     * @param int $now
     * @param int|null $ttl
     * @return int|null
     */
    protected function buildExpiresAt(int $now, int|null $ttl): int|null
    {
        return $ttl === null ? null : $now + $ttl;
    }

    /**
     * Build metadata for cached value
     *
     * @param mixed $value
     * @return array
     */
    protected function buildMetadata(mixed $value): array
    {
        $stringValue = is_scalar($value) ? (string)$value : serialize($value);

        return [
            "type" => gettype($value),
            "size" => strlen($stringValue),
            "hash" => md5($stringValue)
        ];
    }

    /**
     * Check if data has expired
     *
     * @param array $data
     * @return bool
     */
    protected function isExpired(array $data): bool
    {
        return $data["expires_at"] !== null && $data["expires_at"] < time();
    }

    /*----------------------------------------*
     * TTL
     *----------------------------------------*/

    /**
     * Default TTL in seconds
     *
     * @var int|null
     */
    protected int|null $defaultTtl = null;

    /**
     * {@inheritDoc}
     */
    public function setDefaultTtl(int|null $ttl): void
    {
        if ($ttl !== null && $ttl < 0) throw new InvalidTtlException($ttl);

        $this->defaultTtl = $ttl;
    }

    /**
     * {@inheritDoc}
     */
    public function defaultTtl(): int|null
    {
        return $this->defaultTtl;
    }

    /*----------------------------------------*
     * Count
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    abstract public function count(): int;
}
