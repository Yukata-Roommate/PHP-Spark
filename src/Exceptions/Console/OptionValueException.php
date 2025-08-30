<?php

declare(strict_types=1);

namespace Spark\Exceptions\Console;

use Spark\Exceptions\Console\ArgumentException;

/**
 * Option Value Exception
 *
 * @package Spark\Exceptions\Console
 */
class OptionValueException extends ArgumentException
{
    /**
     * Option name
     *
     * @var string
     */
    protected string $option;

    /**
     * Constructor
     *
     * @param string $option
     */
    public function __construct(string $option)
    {
        $this->option = $option;

        parent::__construct("Option \"--{$option}\" requires value");
    }

    /**
     * Get option name
     *
     * @return string
     */
    public function option(): string
    {
        return $this->option;
    }
}
