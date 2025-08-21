<?php

namespace Spark\Supports\Env;

use Spark\Foundation\Entity\Entity;

use Spark\Proxies\Supports;

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
     * constructor
     */
    public function __construct()
    {
        $env = Supports::global()->env();

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
     * get .env path
     *
     * @return string
     */
    protected function path(): string
    {
        return $this->path;
    }

    /**
     * bind .env parameters
     *
     * @return void
     */
    protected function bind(): void {}
}
