<?php

namespace Spark\Supports\Superglobals;

use Spark\Foundation\Entity\ReferenceHandler;

/**
 * Get Reference
 *
 * @package Spark\Supports\Superglobals
 */
class Get extends ReferenceHandler
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
        return $_GET;
    }
}
