<?php

declare(strict_types=1);

namespace Spark\Foundation\Proxy;

/**
 * Proxy Manager
 *
 * @package Spark\Foundation\Proxy
 */
abstract class ProxyManager
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->init();
    }

    /*----------------------------------------*
     * Initialization
     *----------------------------------------*/

    /**
     * Init manager
     *
     * @return void
     */
    abstract protected function init(): void;
}
