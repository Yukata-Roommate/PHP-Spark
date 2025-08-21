<?php

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
     * constructor
     */
    public function __construct()
    {
        $this->init();
    }

    /*----------------------------------------*
     * Initialization
     *----------------------------------------*/

    /**
     * init manager
     *
     * @return void
     */
    abstract protected function init(): void;
}
