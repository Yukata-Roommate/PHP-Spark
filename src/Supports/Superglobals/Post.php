<?php

namespace Spark\Supports\Superglobals;

use Spark\Foundation\Entity\ReferenceHandler;

/**
 * Post Reference
 *
 * @package Spark\Supports\Superglobals
 */
class Post extends ReferenceHandler
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
        return $_POST;
    }
}
