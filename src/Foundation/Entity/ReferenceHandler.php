<?php

namespace Spark\Foundation\Entity;

use Spark\Foundation\Entity\Reference;

/**
 * Reference Handler
 *
 * @package Spark\Foundation\Entity
 */
abstract class ReferenceHandler extends Reference
{
    /*----------------------------------------*
     * Set
     *----------------------------------------*/

    /**
     * set value
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $reference = &$this->reference();

        $reference[$key] = $value;
    }

    /*----------------------------------------*
     * Remove
     *----------------------------------------*/

    /**
     * remove value
     *
     * @param string $key
     * @return void
     */
    public function remove(string $key): void
    {
        $reference = &$this->reference();

        unset($reference[$key]);
    }

    /*----------------------------------------*
     * Clear
     *----------------------------------------*/

    /**
     * clear all values
     *
     * @return void
     */
    public function clear(): void
    {
        $reference = &$this->reference();

        $reference = [];
    }
}
