<?php

declare(strict_types=1);

namespace Spark\Exceptions\Console;

use Spark\Exceptions\Console\CommandException;

/**
 * Class Not Found Exception
 *
 * @package Spark\Exceptions\Console
 */
class ClassNotFoundException extends CommandException
{
    /**
     * Command class name
     *
     * @var string
     */
    protected string $commandClass;

    /**
     * Constructor
     *
     * @param string $commandClass
     */
    public function __construct(string $commandClass)
    {
        $this->commandClass = $commandClass;

        parent::__construct("Command class \"{$commandClass}\" does not exist");
    }

    /**
     * Get command class name
     *
     * @return string
     */
    public function commandClass(): string
    {
        return $this->commandClass;
    }
}
