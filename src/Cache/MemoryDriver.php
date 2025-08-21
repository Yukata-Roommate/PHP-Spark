<?php

namespace Spark\Cache;

use Spark\Contracts\Cache\MemoryDriver as MemoryDriverContract;
use Spark\Foundation\Cache\Driver;

/**
 * Memory Cache Driver
 *
 * @package Spark\Cache
 */
class MemoryDriver extends Driver implements MemoryDriverContract
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * constructor
     *
     * @param int|null $maxItems
     * @param int|null $memoryLimit
     */
    public function __construct(int|null $maxItems = null, int|null $memoryLimit = null)
    {
        $this->setMaxItems($maxItems);
        $this->setMemoryLimit($memoryLimit);
    }

    /*----------------------------------------*
     * Storage
     *----------------------------------------*/

    /**
     * cache storage
     *
     * @var array<string, mixed>
     */
    protected array $storage = [];

    /**
     * storage max items
     *
     * @var int|null
     */
    protected int|null $maxItems = null;

    /**
     * storage memory limit
     *
     * @var int|null
     */
    protected int|null $memoryLimit = null;

    /**
     * set storage max items
     *
     * @param int|null $maxItems
     * @return static
     */
    public function setMaxItems(int|null $maxItems): static
    {
        $this->maxItems = $maxItems;

        if ($this->maxItems === null) return $this;

        while (count($this->storage) > $this->maxItems) {
            $this->evict();
        }

        return $this;
    }

    /**
     * set storage memory limit
     *
     * @param int|null $memoryLimit
     * @return static
     */
    public function setMemoryLimit(int|null $memoryLimit): static
    {
        $this->memoryLimit = $memoryLimit;

        if ($this->memoryLimit === null) return $this;

        while ($this->memoryUsage() > $this->memoryLimit && count($this->storage) > 0) {
            $this->evict();
        }

        return $this;
    }

    /**
     * get memory usage
     *
     * @return int
     */
    public function memoryUsage(): int
    {
        $size = 0;

        foreach ($this->storage as $value) {
            $size += strlen(serialize($value));
        }

        return $size;
    }

    /*----------------------------------------*
     * Load
     *----------------------------------------*/

    /**
     * whether key exists in storage
     *
     * @param string $key
     * @return bool
     */
    protected function has(string $key): bool
    {
        return isset($this->storage[$key]);
    }

    /**
     * read raw data from storage
     *
     * @param string $key
     * @return mixed
     */
    protected function read(string $key): mixed
    {
        if (!$this->has($key)) throw new \RuntimeException("Cache file does not exist. key: $key");

        return $this->storage[$key];
    }

    /**
     * loaded
     *
     * @param string $key
     * @param array $data
     * @return void
     */
    #[\Override]
    protected function loaded(string $key, array &$data): void
    {
        $this->access($key);
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
    protected function write(string $key, array $data): void
    {
        $this->storage[$key] = $data;

        $this->access($key);
    }

    /**
     * prepare saving
     *
     * @param string $key
     * @param mixed $value
     * @param int|null $ttl
     * @return void
     */
    #[\Override]
    protected function prepareSave(string $key, mixed &$value, int|null $ttl = null): void
    {
        $this->ensureMaxItems($key);

        $this->ensureMemoryLimit($value);
    }

    /**
     * ensure storage has value capacity
     *
     * @param string $key
     * @return void
     */
    protected function ensureMaxItems(string $key): void
    {
        if ($this->maxItems === null) return;

        if (!$this->has($key)) return;

        while (count($this->storage) >= $this->maxItems) {
            $this->evict();
        }
    }

    /**
     * ensure sufficient memory for value
     *
     * @param mixed $value
     * @return void
     */
    protected function ensureMemoryLimit(mixed $value): void
    {
        if ($this->memoryLimit === null) return;

        $size = strlen(serialize($value));

        if ($size > $this->memoryLimit) throw new \RuntimeException("Value size exceeds memory limit: $size bytes, limit: {$this->memoryLimit} bytes");

        while ($this->memoryUsage() + $size > $this->memoryLimit && count($this->storage) > 0) {
            $this->evict();
        }
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
    protected function remove(string $key): void
    {
        unset($this->storage[$key], $this->accessTime[$key]);
    }

    /**
     * flush all cache values from storage
     *
     * @return void
     */
    protected function flush(): void
    {
        $this->storage     = [];
        $this->accessTimes = [];
    }

    /**
     * clean expired cache values
     *
     * @return int
     */
    public function clean(): int
    {
        $keys = array_keys($this->storage);

        if (empty($keys)) return 0;

        $count = 0;

        foreach ($keys as $key) {
            try {
                $data = $this->read($key);

                $validated = $this->ensureDataStructure($data);

                if (!$this->isExpired($validated)) continue;

                $this->delete($key);

                $count++;
            } catch (\Throwable $e) {
                continue;
            }
        }

        return $count;
    }

    /*----------------------------------------*
     * Least Recently Used
     *----------------------------------------*/

    /**
     * access times
     *
     * @var array<string, int>
     */
    protected array $accessTimes = [];

    /**
     * add access time for key
     *
     * @param string $key
     * @return void
     */
    protected function access(string $key): void
    {
        $this->accessTimes[$key] = microtime(true);
    }

    /**
     * evict least recently used item
     *
     * @return void
     */
    protected function evict(): void
    {
        if (empty($this->accessTimes)) return;

        // Find the key with the oldest access time
        $lruKey = array_search(min($this->accessTimes), $this->accessTimes);

        if ($lruKey === false) return;

        $this->remove($lruKey);
    }
}
