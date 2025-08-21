<?php

namespace Spark\Supports\Global;

use Spark\Foundation\Entity\ReferenceHandler;

/**
 * Get Reference
 *
 * @package Spark\Supports\Global
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
