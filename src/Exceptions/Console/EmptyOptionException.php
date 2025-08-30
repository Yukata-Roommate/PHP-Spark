<?php

declare(strict_types=1);

namespace Spark\Exceptions\Console;

use Spark\Exceptions\Console\ArgumentException;

/**
 * Empty Option Exception
 *
 * @package Spark\Exceptions\Console
 */
class EmptyOptionException extends ArgumentException
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct("Option name cannot be empty after \"--\"");
    }
}
