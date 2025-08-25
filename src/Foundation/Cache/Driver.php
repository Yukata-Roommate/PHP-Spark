<?php

namespace Spark\Foundation\Cache;

use Spark\Contracts\Cache\Driver as DriverContract;

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
     * whether key exists in storage
     *
     * @param string $key
     * @return bool
     */
    abstract protected function has(string $key): bool;

    /**
     * read raw data from storage
     *
     * @param string $key
     * @return mixed
     */
    abstract protected function read(string $key): mixed;

    /**
     * load cache value
     *
     * @param string $key
     * @return mixed
     */
    public function load(string $key): mixed
    {
        if (!$this->has($key)) throw new \RuntimeException("Cache key \"$key\" does not exist.");

        $data = $this->read($key);

        $validated = $this->ensureDataStructure($data);

        if ($this->isExpired($validated)) {
            $this->delete($key);

            throw new \RuntimeException("Cache key \"$key\" has expired.");
        }

        $this->loaded($key, $validated);

        return $validated["value"];
    }

    /**
     * loaded
     *
     * @param string $key
     * @param array $data
     * @return void
     */
    protected function loaded(string $key, array &$data): void {}

    /**
     * safely load cache value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function safeLoad(string $key, mixed $default = null): mixed
    {
        try {
            return $this->load($key);
        } catch (\Throwable $e) {
            return $default;
        }
    }

    /**
     * load multiple cache values
     *
     * @param array $keys
     * @return array
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
     * get cache value ensure exists
     *
     * @param string $key
     * @param callable $callback
     * @param int|null $ttl
     * @return mixed
     */
    public function remember(string $key, callable $callback, int|null $ttl = null): mixed
    {
        if ($this->exists($key)) return $this->load($key);

        $value = $callback();

        $this->save($key, $value, $ttl);

        return $value;
    }

    /**
     * whether exists cache value
     *
     * @param string $key
     * @return bool
     */
    public function exists(string $key): bool
    {
        if (!$this->has($key)) return false;

        try {
            $data = $this->read($key);

            $validated = $this->ensureDataStructure($data);

            if (!$this->isExpired($validated)) return true;

            $this->delete($key);

            return false;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /*----------------------------------------*
     * Save
     *----------------------------------------*/

    /**
     * write data to storage
     *
     * @param string $key
     * @param array $data
     * @return void
     */
    abstract protected function write(string $key, array $data): void;

    /**
     * save cache value
     *
     * @param string $key
     * @param mixed $value
     * @param int|null $ttl
     * @return array
     */
    public function save(string $key, mixed $value, int|null $ttl = null): array
    {
        if ($ttl !== null && $ttl < 0) throw new \InvalidArgumentException("TTL must be a positive integer or null.");

        $this->prepareSave($key, $value, $ttl);

        $data = $this->buildDataStructure($value, $ttl);

        $this->write($key, $data);

        $this->saved($key, $data);

        return $data;
    }

    /**
     * prepare saving
     *
     * @param string $key
     * @param mixed $value
     * @param int|null $ttl
     * @return void
     */
    protected function prepareSave(string $key, mixed &$value, int|null $ttl = null): void {}

    /**
     * saved
     *
     * @param string $key
     * @param array $data
     * @return void
     */
    protected function saved(string $key, array &$data): void {}

    /**
     * save multiple cache values
     *
     * @param array $values
     * @param int|null $ttl
     * @return int
     */
    public function saveMany(array $values, int|null $ttl = null): int
    {
        foreach ($values as $key => $value) {
            $this->save($key, $value, $ttl);
        }

        return count($values);
    }

    /**
     * increment numeric cache value
     *
     * @param string $key
     * @param int $step
     * @return int
     */
    public function increment(string $key, int $step = 1): int
    {
        $value = $this->safeLoad($key, 0);

        if (!is_numeric($value)) throw new \RuntimeException("Cache value for key \"{$key}\" is not numeric.");

        $newValue = (int)$value + $step;

        $this->save($key, $newValue);

        return $newValue;
    }

    /**
     * decrement numeric cache value
     *
     * @param string $key
     * @param int $step
     * @return int
     */
    public function decrement(string $key, int $step = 1): int
    {
        return $this->increment($key, -$step);
    }

    /*----------------------------------------*
     * Delete
     *----------------------------------------*/

    /**
     * remove cache value from storage
     *
     * @param string $key
     * @return void
     */
    abstract protected function remove(string $key): void;

    /**
     * flush all cache values from storage
     *
     * @return void
     */
    abstract protected function flush(): void;

    /**
     * clean expired cache values
     *
     * @return int
     */
    abstract public function clean(): int;

    /**
     * delete cache value
     *
     * @param string $key
     * @return void
     */
    public function delete(string $key): void
    {
        if (!$this->has($key)) return;

        $this->remove($key);
    }

    /**
     * clear all cache values
     *
     * @return void
     */
    public function clear(): void
    {
        $this->flush();
    }

    /**
     * delete multiple cache values
     *
     * @param array $keys
     * @return int
     */
    public function deleteMany(array $keys): int
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }

        return count($keys);
    }

    /*----------------------------------------*
     * Data Structure
     *----------------------------------------*/

    /**
     * ensure data structure
     *
     * @param mixed $data
     * @return array
     */
    protected function ensureDataStructure(mixed $data): array
    {
        if (!is_array($data)) throw new \RuntimeException("Data must be an array, " . gettype($data) . " given.");

        if (!array_key_exists("value", $data)) throw new \RuntimeException("Data must contain a \"value\" key.");

        if (!array_key_exists("created_at", $data)) throw new \RuntimeException("Data must contain an \"created_at\" key.");

        if (!array_key_exists("expires_at", $data)) throw new \RuntimeException("Data must contain a \"expires_at\" key.");

        if (!array_key_exists("metadata", $data)) throw new \RuntimeException("Data must contain a \"metadata\" key.");

        return $data;
    }

    /**
     * build data structure
     *
     * @param mixed $value
     * @param int|null $ttl
     * @return array
     */
    protected function buildDataStructure(mixed $value, int|null $ttl = null): array
    {
        $now = time();

        $expiresAt = $this->buildExpiresAt($now, $ttl);
        $metadata  = $this->buildMetadata($value);

        return [
            "value"      => $value,
            "created_at" => $now,
            "expires_at" => $expiresAt,
            "metadata"   => $metadata
        ];
    }

    /**
     * build expires at
     *
     * @param int $now
     * @param int|null $ttl
     * @return int|null
     */
    protected function buildExpiresAt(int $now, int|null $ttl): int|null
    {
        if ($ttl === null) return null;

        return $now + $ttl;
    }

    /**
     * build metadata
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
     * whether data is expired
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
     * default ttl in seconds
     *
     * @var int|null
     */
    protected int|null $defaultTtl = null;

    /**
     * set default ttl
     *
     * @param int|null $ttl
     * @return void
     */
    public function setDefaultTtl(int|null $ttl): void
    {
        if ($ttl !== null && $ttl < 0) throw new \InvalidArgumentException("TTL must be a positive integer or null.");

        $this->defaultTtl = $ttl;
    }

    /**
     * get default ttl
     *
     * @return int|null
     */
    public function defaultTtl(): int|null
    {
        return $this->defaultTtl;
    }
}
