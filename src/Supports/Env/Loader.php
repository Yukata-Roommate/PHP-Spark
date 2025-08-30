<?php

declare(strict_types=1);

namespace Spark\Supports\Env;

use Spark\Foundation\Container\Entity;

use Spark\Proxies\Superglobals;

/**
 * Env Loader
 *
 * @package Spark\Supports\Env
 */
class Loader extends Entity
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * Constructor
     */
    public function __construct()
    {
        $env = Superglobals::env();

        $env->load($this->path());

        parent::__construct($env->all());

        $this->bind();
    }

    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * .env file path
     *
     * @var string
     */
    protected string $path = __DIR__ . "/../../../../../../.env";

    /*----------------------------------------*
     * Method
     *----------------------------------------*/

    /**
     * Get .env path
     *
     * @return string
     */
    protected function path(): string
    {
        return $this->path;
    }

    /**
     * Bind .env parameters
     *
     * @return void
     */
    protected function bind(): void {}
}
