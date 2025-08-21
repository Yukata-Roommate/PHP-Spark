<?php

namespace Spark\Foundation\Entity;

use Spark\Foundation\Entity\DataAccessor;

/**
 * Reference
 *
 * @package Spark\Foundation\Entity
 */
abstract class Reference extends DataAccessor
{
    /*----------------------------------------*
     * Accessor
     *----------------------------------------*/

    /**
     * get value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $reference = &$this->reference();

        return $reference[$key] ?? $default;
    }

    /*----------------------------------------*
     * Reference
     *----------------------------------------*/

    /**
     * get reference
     *
     * @return array
     */
    abstract protected function &reference(): array;

    /**
     * get global variables
     *
     * @return array
     */
    public function all(): array
    {
        return $this->reference();
    }

    /**
     * get keys
     *
     * @return array
     */
    public function keys(): array
    {
        return array_keys($this->reference());
    }

    /**
     * get values
     *
     * @return array
     */
    public function values(): array
    {
        return array_values($this->reference());
    }

    /**
     * get count
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->reference());
    }

    /*----------------------------------------*
     * Check
     *----------------------------------------*/

    /**
     * whether is empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        $reference = &$this->reference();

        return empty($reference);
    }

    /**
     * whether has key
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        $reference = &$this->reference();

        return array_key_exists($key, $reference);
    }
}
