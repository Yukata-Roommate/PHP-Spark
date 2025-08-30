<?php

declare(strict_types=1);

namespace Spark\Exceptions\Console;

use Spark\Exceptions\Console\CommandException;

/**
 * Signature Exception
 *
 * @package Spark\Exceptions\Console
 */
class SignatureException extends CommandException
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

        parent::__construct("Command signature is not defined in \"{$commandClass}\"");
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
