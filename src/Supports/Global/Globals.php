<?php

namespace Spark\Supports\Global;

use Spark\Foundation\Entity\ReferenceHandler;

/**
 * Globals Reference
 *
 * @package Spark\Supports\Global
 */
class Globals extends ReferenceHandler
{
    /*----------------------------------------*
     * Reference
     *----------------------------------------*/

    /**
     * get reference
     *
     * @return array
     */
    protected function &reference(): array
    {
        return $GLOBALS;
    }

    /**
     * get value reference
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
     * set value reference
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
