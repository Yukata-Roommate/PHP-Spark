<?php

declare(strict_types=1);

namespace Spark\Supports\Superglobals;

use Spark\Foundation\Container\MutableReference;

/**
 * Globals Reference
 *
 * @package Spark\Supports\Superglobals
 */
class Globals extends MutableReference
{
    /*----------------------------------------*
     * Reference
     *----------------------------------------*/

    /**
     * Get reference
     *
     * @return array
     */
    protected function &reference(): array
    {
        return $GLOBALS;
    }

    /**
     * Get value reference
     *
     * @param string $key
     * @return mixed
     */
    public function &getReference(string $key): mixed
    {
        $reference = &$this->reference();

        return $reference[$key];
    }

    /**
     * Set value reference
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setReference(string $key, mixed &$value): void
    {
        $reference = &$this->reference();

        $reference[$key] = &$value;
    }
}
