<?php

declare(strict_types=1);

namespace Spark\Exceptions\Console;

use Spark\Exceptions\Console\ArgumentException;

/**
 * No Arguments Exception
 *
 * @package Spark\Exceptions\Console
 */
class NoArgumentsException extends ArgumentException
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct("No arguments provided");
    }
}
