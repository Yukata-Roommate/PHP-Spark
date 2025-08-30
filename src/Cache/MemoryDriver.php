<?php

declare(strict_types=1);

namespace Spark\Cache;

use Spark\Contracts\Cache\MemoryDriver as MemoryDriverContract;
use Spark\Foundation\Cache\Driver;

use Spark\Exceptions\Cache\CacheException;
use Spark\Exceptions\Cache\InvalidMaxItemsException;
use Spark\Exceptions\Cache\InvalidMemoryLimitException;
use Spark\Exceptions\Cache\MemoryLimitExceededException;
use Spark\Exceptions\Cache\ItemsLimitExceededException;

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
     * Constructor
     *
     * @param int|null $maxItems
     * @param int|null $memoryLimit
     * @throws \Spark\Exceptions\Cache\InvalidMaxItemsException
     * @throws \Spark\Exceptions\Cache\InvalidMemoryLimitException
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
     * Cache storage
     *
     * @var array<string, mixed>
     */
    protected array $storage = [];

    /**
     * Storage max items
     *
     * @var int|null
     */
    protected int|null $maxItems = null;

    /**
     * Storage memory limit in bytes
     *
     * @var int|null
     */
    protected int|null $memoryLimit = null;

    /**
     * {@inheritDoc}
     */
    public function setMaxItems(int|null $maxItems): static
    {
        if ($maxItems !== null && $maxItems <= 0) throw new InvalidMaxItemsException($maxItems);

        $this->maxItems = $maxItems;

        if ($this->maxItems === null) return $this;

        while (count($this->storage) > $this->maxItems) {
            $this->evict();
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function maxItems(): int|null
    {
        return $this->maxItems;
    }

    /**
     * {@inheritDoc}
     */
    public function setMemoryLimit(int|null $memoryLimit): static
    {
        if ($memoryLimit !== null && $memoryLimit <= 0) throw new InvalidMemoryLimitException($memoryLimit);

        $this->memoryLimit = $memoryLimit;

        if ($this->memoryLimit === null) return $this;

        while ($this->memoryUsage() > $this->memoryLimit && count($this->storage) > 0) {
            $this->evict();
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function memoryLimit(): int|null
    {
        return $this->memoryLimit;
    }

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    protected function has(string $key): bool
    {
        return isset($this->storage[$key]);
    }

    /**
     * {@inheritDoc}
     */
    protected function read(string $key): mixed
    {
        return $this->storage[$key];
    }

    /**
     * {@inheritDoc}
     */
    #[\Override]
    protected function loaded(string $key, array &$data): void
    {
        $this->updateAccessOrder($key);
    }

    /*----------------------------------------*
     * Save
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    protected function write(string $key, array $data): void
    {
        $this->storage[$key] = $data;

        $this->updateAccessOrder($key);
    }

    /**
     * {@inheritDoc}
     * @throws \Spark\Exceptions\Cache\ItemsLimitExceededException
     * @throws \Spark\Exceptions\Cache\MemoryLimitExceededException
     */
    #[\Override]
    protected function prepareSave(string $key, mixed &$value, int|null $ttl = null): void
    {
        $this->ensureMaxItems($key);

        $this->ensureMemoryLimit($key, $value);
    }

    /**
     * Ensure storage has capacity for new item
     *
     * @param string $key
     * @return void
     * @throws \Spark\Exceptions\Cache\ItemsLimitExceededException
     */
    protected function ensureMaxItems(string $key): void
    {
        if ($this->maxItems === null) return;

        if ($this->has($key)) return;

        $currentCount = count($this->storage);

        if ($currentCount < $this->maxItems) return;

        if ($this->evict()) return;

        throw new ItemsLimitExceededException($currentCount, $this->maxItems);
    }

    /**
     * Ensure sufficient memory for value
     *
     * @param string $key
     * @param mixed $value
     * @return void
     * @throws \Spark\Exceptions\Cache\MemoryLimitExceededException
     */
    protected function ensureMemoryLimit(string $key, mixed $value): void
    {
        if ($this->memoryLimit === null) return;

        $serialized = serialize($value);

        $size = strlen($serialized);

        if ($size > $this->memoryLimit) throw new MemoryLimitExceededException($size, $this->memoryLimit);

        $currentSize = 0;
        if ($this->has($key)) $currentSize = strlen(serialize($this->storage[$key]));

        $netChange = $size - $currentSize;

        $projectedUsage = $this->memoryUsage() + $netChange;

        while ($projectedUsage > $this->memoryLimit && count($this->storage) > 0) {
            if (count($this->storage) === 1 && $this->has($key)) break;

            if (!$this->evict($key)) throw new MemoryLimitExceededException($projectedUsage, $this->memoryLimit);

            $projectedUsage = $this->memoryUsage() + $netChange;
        }
    }

    /*----------------------------------------*
     * Delete
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    protected function remove(string $key): void
    {
        unset($this->storage[$key], $this->accessOrder[$key]);
    }

    /**
     * {@inheritDoc}
     */
    protected function flush(): void
    {
        $this->storage = [];

        $this->accessOrder = [];
    }

    /**
     * {@inheritDoc}
     */
    public function clean(): int
    {
        $keys = array_keys($this->storage);

        $count = 0;

        foreach ($keys as $key) {
            try {
                $data = $this->read($key);

                $validated = $this->ensureDataStructure($data, $key);

                if (!$this->isExpired($validated)) continue;

                $this->delete($key);

                $count++;
            } catch (CacheException) {
                $this->delete($key);

                $count++;
            }
        }

        return $count;
    }

    /*----------------------------------------*
     * Least Recently Used (LRU)
     *----------------------------------------*/

    /**
     * Access order for LRU eviction
     *
     * @var array<string, true>
     */
    protected array $accessOrder = [];

    /**
     * Update access order for LRU tracking
     *
     * @param string $key
     * @return void
     */
    protected function updateAccessOrder(string $key): void
    {
        unset($this->accessOrder[$key]);

        $this->accessOrder[$key] = true;
    }

    /**
     * Evict least recently used item
     *
     * @param string|null $excludeKey
     * @return bool
     */
    protected function evict(string|null $excludeKey = null): bool
    {
        if (empty($this->accessOrder)) return false;

        foreach (array_keys($this->accessOrder) as $lruKey) {
            if ($excludeKey !== null && $lruKey === $excludeKey) continue;

            $this->remove($lruKey);

            return true;
        }

        return false;
    }

    /*----------------------------------------*
     * Count
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return count($this->storage);
    }
}
