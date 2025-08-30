<?php

declare(strict_types=1);

namespace Spark\Concerns\Container;

/**
 * Mutable
 *
 * @package Spark\Concerns\Container
 *
 * @method mixed mutableSource()
 */
trait Mutable
{
    /**
     * Check if source is object
     *
     * @return bool
     */
    protected function isObjectSource(): bool
    {
        $source = &$this->mutableSource();

        return is_object($source);
    }

    /**
     * Set property value
     *
     * @param string $name
     * @param mixed $value
     * @return static
     */
    public function set(string $name, mixed $value): static
    {
        $source = &$this->mutableSource();

        if ($this->isObjectSource()) {
            $source->{$name} = $value;
        } else {
            $source[$name] = $value;
        }

        return $this;
    }

    /**
     * Add property value
     *
     * @param string $name
     * @param mixed $value
     * @return static
     */
    public function add(string $name, mixed $value): static
    {
        return $this->set($name, $value);
    }

    /**
     * Remove property
     *
     * @param string $name
     * @return static
     */
    public function remove(string $name): static
    {
        $source = &$this->mutableSource();

        if ($this->isObjectSource()) {
            unset($source->{$name});
        } else {
            unset($source[$name]);
        }

        return $this;
    }

    /**
     * Delete property
     *
     * @param string $name
     * @return static
     */
    public function delete(string $name): static
    {
        return $this->remove($name);
    }

    /**
     * Unset property
     *
     * @param string $name
     * @return static
     */
    public function unset(string $name): static
    {
        return $this->remove($name);
    }

    /**
     * Clear all values
     *
     * @return static
     */
    public function clear(): static
    {
        $source = &$this->mutableSource();

        if ($this->isObjectSource()) {
            foreach (array_keys(get_object_vars($source)) as $key) {
                unset($source->{$key});
            }
        } else {
            $source = [];
        }

        return $this;
    }

    /**
     * Flush all data
     *
     * @return static
     */
    public function flush(): static
    {
        return $this->clear();
    }
}
