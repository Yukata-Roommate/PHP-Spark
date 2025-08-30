<?php

declare(strict_types=1);

namespace Spark\Exceptions\Console;

use Spark\Exceptions\Console\CommandException;

/**
 * Command Not Found Exception
 *
 * @package Spark\Exceptions\Console
 */
class CommandNotFoundException extends CommandException
{
    /**
     * Command signature
     *
     * @var string
     */
    protected string $signature;

    /**
     * Constructor
     *
     * @param string $signature
     */
    public function __construct(string $signature)
    {
        $this->signature = $signature;

        parent::__construct("Command \"{$signature}\" not found");
    }

    /**
     * Get command signature
     *
     * @return string
     */
    public function signature(): string
    {
        return $this->signature;
    }
}
