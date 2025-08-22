<?php

namespace Spark\Console;

use Spark\Contracts\Console\ArgvInput as ArgvInputContract;

/**
 * Console ArgvInput
 *
 * @package Spark\Console
 */
class ArgvInput implements ArgvInputContract
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * constructor
     *
     * @param array<string>|array<string, string> $argv
     */
    public function __construct(array $argv = [])
    {
        $arguments = empty($argv) ? $_SERVER["argv"] : $argv;

        $this->script  = array_shift($arguments);

        $this->signature = empty($arguments) ? "" : array_shift($arguments);

        $arguments = $this->parseArguments($arguments);

        $this->arguments = $arguments;
    }

    /*----------------------------------------*
     * Argument
     *----------------------------------------*/

    /**
     * arguments
     *
     * @var array<string|int, string|int>
     */
    protected array $arguments;

    /**
     * script
     *
     * @var string
     */
    protected string $script;

    /**
     * command signature
     *
     * @var string
     */
    protected string $signature;

    /**
     * get arguments
     *
     * @return array<string|int, string|int>
     */
    public function arguments(): array
    {
        return $this->arguments;
    }

    /**
     * get script
     *
     * @return string
     */
    public function script(): string
    {
        return $this->script;
    }

    /**
     * get command signature
     *
     * @return string
     */
    public function signature(): string
    {
        return $this->signature;
    }

    /*----------------------------------------*
     * Parse
     *----------------------------------------*/

    /**
     * parse arguments from command line
     *
     * @param array<string|int, string|int> $arguments
     * @return array<string|int, string|int>
     */
    protected function parseArguments(array $arguments): array
    {
        $parsedArguments = [];

        while (count($arguments) > 0) {
            $argument = array_shift($arguments);

            if (preg_match("/^--/", $argument)) {
                $argument = preg_replace("/^--/", "", $argument);

                if (preg_match("/=/", $argument)) {
                    $argument = explode("=", $argument);

                    $key   = array_shift($argument);
                    $value = array_shift($argument);

                    $parsedArguments[$key] = $value;
                } else {
                    $value = array_shift($arguments);

                    $parsedArguments[$argument] = $value;
                }

                continue;
            }

            $parsedArguments[] = $argument;
        }

        return $parsedArguments;
    }
}
