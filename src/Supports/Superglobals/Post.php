<?php

declare(strict_types=1);

namespace Spark\Supports\Superglobals;

use Spark\Foundation\Container\MutableReference;

/**
 * Post Reference
 *
 * @package Spark\Supports\Superglobals
 */
class Post extends MutableReference
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
        return $_POST;
    }
}
