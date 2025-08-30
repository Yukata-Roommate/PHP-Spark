<?php

declare(strict_types=1);

namespace Spark\Console;

use Spark\Contracts\Console\ArgvInput as ArgvInputContract;

use Spark\Exceptions\Console\NoArgumentsException;
use Spark\Exceptions\Console\MalformedArgumentException;
use Spark\Exceptions\Console\EmptyOptionException;
use Spark\Exceptions\Console\OptionValueException;

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
     * Constructor
     *
     * @param array<int, string>|null $argv
     * @throws \Spark\Exceptions\Console\NoArgumentsException
     * @throws \Spark\Exceptions\Console\MalformedArgumentException
     * @throws \Spark\Exceptions\Console\EmptyOptionException
     * @throws \Spark\Exceptions\Console\OptionValueException
     */
    public function __construct(array|null $argv = null)
    {
        if ($argv === null) $argv = $_SERVER["argv"] ?? [];

        if (empty($argv)) throw new NoArgumentsException();

        $this->script = array_shift($argv);

        $this->signature = empty($argv) ? "" : array_shift($argv);

        $this->arguments = $this->parseArguments($argv);
    }

    /*----------------------------------------*
     * Argument
     *----------------------------------------*/

    /**
     * Parsed arguments
     *
     * @var array<string|int, string|int>
     */
    protected array $arguments;

    /**
     * Script name
     *
     * @var string
     */
    protected string $script;

    /**
     * Command signature
     *
     * @var string
     */
    protected string $signature;

    /**
     * {@inheritDoc}
     */
    public function arguments(): array
    {
        return $this->arguments;
    }

    /**
     * {@inheritDoc}
     */
    public function script(): string
    {
        return $this->script;
    }

    /**
     * {@inheritDoc}
     */
    public function signature(): string
    {
        return $this->signature;
    }

    /*----------------------------------------*
     * Parse
     *----------------------------------------*/

    /**
     * Parse arguments from command line format
     *
     * @param array<int, string> $arguments
     * @return array<string|int, string|int>
     * @throws \Spark\Exceptions\Console\MalformedArgumentException
     * @throws \Spark\Exceptions\Console\EmptyOptionException
     * @throws \Spark\Exceptions\Console\OptionValueException
     */
    protected function parseArguments(array $arguments): array
    {
        $parsedArguments = [];

        while (count($arguments) > 0) {
            $argument = array_shift($arguments);

            $this->validateArgument($argument);

            if ($this->isOption($argument)) {
                $this->parseOption($argument, $arguments, $parsedArguments);
            } else {
                $parsedArguments[] = $argument;
            }
        }

        return $parsedArguments;
    }

    /**
     * Validate argument format
     *
     * @param mixed $argument
     * @return void
     * @throws \Spark\Exceptions\Console\MalformedArgumentException
     */
    protected function validateArgument(mixed $argument): void
    {
        if (!is_string($argument)) throw new MalformedArgumentException((string)$argument);
    }

    /**
     * Check if argument is option
     *
     * @param string $argument
     * @return bool
     */
    protected function isOption(string $argument): bool
    {
        return (bool)preg_match("/^--/", $argument);
    }

    /**
     * Parse option and add it to parsed arguments
     *
     * @param string $argument
     * @param array<int, mixed> $arguments
     * @param array<string|int, string|int> $parsedArguments
     * @return void
     * @throws \Spark\Exceptions\Console\MalformedArgumentException
     * @throws \Spark\Exceptions\Console\EmptyOptionException
     * @throws \Spark\Exceptions\Console\OptionValueException
     */
    protected function parseOption(string $argument, array &$arguments, array &$parsedArguments): void
    {
        $optionString = preg_replace("/^--/", "", $argument);

        if (empty($optionString)) throw new EmptyOptionException();

        if ($this->hasInlineValue($optionString)) {
            $this->parseInlineOption($optionString, $parsedArguments);
        } else {
            $this->parseStandaloneOption($optionString, $arguments, $parsedArguments);
        }
    }

    /**
     * Check if argument contains inline value
     *
     * @param string $optionString
     * @return bool
     */
    protected function hasInlineValue(string $optionString): bool
    {
        return (bool)preg_match("/=/", $optionString);
    }

    /**
     * Parse option with inline value
     *
     * @param string $optionString
     * @param array<string|int, string|int> $parsedArguments
     * @return void
     * @throws \Spark\Exceptions\Console\MalformedArgumentException
     * @throws \Spark\Exceptions\Console\EmptyOptionException
     */
    protected function parseInlineOption(string $optionString, array &$parsedArguments): void
    {
        $parts = explode("=", $optionString, 2);

        if (count($parts) !== 2) throw new MalformedArgumentException("--{$optionString}");

        [$key, $value] = $parts;

        if (empty($key)) throw new EmptyOptionException();

        $parsedArguments[$key] = $value;
    }

    /**
     * Parse standalone option
     *
     * @param string $optionName
     * @param array<int, mixed> $arguments
     * @param array<string|int, string|int> $parsedArguments
     * @return void
     * @throws \Spark\Exceptions\Console\OptionValueException
     */
    protected function parseStandaloneOption(string $optionName, array &$arguments, array &$parsedArguments): void
    {
        if (count($arguments) === 0) throw new OptionValueException($optionName);

        $value = array_shift($arguments);

        if (!is_string($value) || $this->isOption($value)) {
            array_unshift($arguments, $value);

            throw new OptionValueException($optionName);
        }

        $parsedArguments[$optionName] = $value;
    }
}
