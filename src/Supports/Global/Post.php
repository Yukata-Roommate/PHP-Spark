<?php

namespace Spark\Supports\Global;

use Spark\Foundation\Entity\ReferenceHandler;

/**
 * Post Reference
 *
 * @package Spark\Supports\Global
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
