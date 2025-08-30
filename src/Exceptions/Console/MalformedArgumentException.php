<?php

declare(strict_types=1);

namespace Spark\Exceptions\Console;

use Spark\Exceptions\Console\ArgumentException;

/**
 * Malformed Argument Exception
 *
 * @package Spark\Exceptions\Console
 */
class MalformedArgumentException extends ArgumentException
{
    /**
     * Raw argument string
     *
     * @var string
     */
    protected string $rawArgument;

    /**
     * Constructor
     *
     * @param string $rawArgument
     */
    public function __construct(string $rawArgument)
    {
        $this->rawArgument = $rawArgument;

        parent::__construct("Malformed argument: \"{$rawArgument}\"");
    }

    /**
     * Get raw argument string
     *
     * @return string
     */
    public function rawArgument(): string
    {
        return $this->rawArgument;
    }
}
