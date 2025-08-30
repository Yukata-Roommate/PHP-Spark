<?php

declare(strict_types=1);

namespace Spark\Foundation\Console;

use Spark\Contracts\Console\Command as CommandContract;

use Spark\Contracts\Console\Output as OutputContract;
use Spark\Console\Output;

use Spark\Exceptions\Console\ArgumentRequiredException;
use Spark\Exceptions\Console\UnexpectedTypeException;
use Spark\Exceptions\Console\UnexpectedFormatException;
use Spark\Exceptions\Console\ValidationException;

/**
 * Command
 *
 * @package Spark\Foundation\Console
 */
abstract class Command implements CommandContract
{
    /**
     * Signature
     *
     * @var string
     */
    protected string $signature;

    /**
     * Description
     *
     * @var string
     */
    protected string $description;

    /**
     * {@inheritDoc}
     */
    public function signature(): string
    {
        return $this->signature;
    }

    /**
     * {@inheritDoc}
     */
    public function description(): string
    {
        return $this->description;
    }

    /*----------------------------------------*
     * Run
     *----------------------------------------*/

    /**
     * {@inheritDoc}
     */
    public function run(array $arguments): void
    {
        $this->arguments = $arguments;

        $this->prepareValidation();

        $this->validate();

        if (!empty($this->errors)) $this->failedValidation();

        $this->passedValidation();

        try {
            $this->execute();
        } catch (\Exception $exception) {
            $this->handleExecutionException($exception);

            throw $exception;
        }
    }

    /**
     * Execute command logic
     *
     * @return void
     */
    abstract protected function execute(): void;

    /**
     * Handle exceptions during command execution
     *
     * @param \Exception $exception
     * @return void
     */
    protected function handleExecutionException(\Exception $exception): void {}

    /*----------------------------------------*
     * Arguments
     *----------------------------------------*/

    /**
     * Command arguments
     *
     * @var array<string|int, string|int>
     */
    protected array $arguments;

    /**
     * Get all arguments
     *
     * @return array<string|int, string|int>
     */
    protected function arguments(): array
    {
        return $this->arguments;
    }

    /**
     * Check if argument exists and is not empty
     *
     * @param int|string $key
     * @return bool
     */
    protected function has(string|int $key): bool
    {
        return isset($this->arguments[$key]) && $this->arguments[$key] !== "";
    }

    /**
     * Get required argument value
     *
     * @param string|int $key
     * @return string|int
     * @throws \Spark\Exceptions\Console\ArgumentRequiredException
     */
    protected function required(string|int $key): string|int
    {
        if (!$this->has($key)) throw new ArgumentRequiredException($key);

        return $this->arguments[$key];
    }

    /**
     * Get required argument value as string
     *
     * @param string|int $key
     * @return string
     * @throws \Spark\Exceptions\Console\ArgumentRequiredException
     * @throws \Spark\Exceptions\Console\UnexpectedTypeException
     */
    protected function requiredString(string|int $key): string
    {
        $value = $this->required($key);

        if (!is_string($value)) throw new UnexpectedTypeException($key, "string", gettype($value));

        return $value;
    }

    /**
     * Get required argument value as integer
     *
     * @param string|int $key
     * @return int
     * @throws \Spark\Exceptions\Console\ArgumentRequiredException
     * @throws \Spark\Exceptions\Console\UnexpectedTypeException
     */
    protected function requiredInt(string|int $key): int
    {
        $value = $this->required($key);

        if (!is_numeric($value)) throw new UnexpectedTypeException($key, "integer", gettype($value));

        if (!preg_match("/^-?\d+$/", (string)$value)) throw new UnexpectedTypeException($key, "integer", "numeric");

        return (int)$value;
    }

    /**
     * Get required argument value as float
     *
     * @param string|int $key
     * @return float
     * @throws \Spark\Exceptions\Console\ArgumentRequiredException
     * @throws \Spark\Exceptions\Console\UnexpectedTypeException
     */
    protected function requiredFloat(string|int $key): float
    {
        $value = $this->required($key);

        if (!is_numeric($value)) throw new UnexpectedTypeException($key, "float", gettype($value));

        return (float)$value;
    }

    /**
     * Get required argument value as boolean
     *
     * @param string|int $key
     * @return boolean
     * @throws \Spark\Exceptions\Console\ArgumentRequiredException
     * @throws \Spark\Exceptions\Console\UnexpectedTypeException
     */
    protected function requiredBool(string|int $key): bool
    {
        $value = $this->required($key);

        $filtered = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if (is_null($filtered)) throw new UnexpectedTypeException($key, "boolean", gettype($value));

        return $filtered;
    }

    /**
     * Get argument value by key
     *
     * @param int|string $key
     * @param string|int|null $default
     * @return int|string|null
     */
    protected function get(string|int $key, string|int|null $default = null): int|string|null
    {
        try {
            return $this->required($key);
        } catch (ArgumentRequiredException) {
            return $default;
        }
    }

    /**
     * Get argument value by key as string
     *
     * @param int|string $key
     * @param string|null $default
     * @return string|null
     * @throws \Spark\Exceptions\Console\UnexpectedTypeException
     */
    protected function string(string|int $key, string|null $default = null): string|null
    {
        try {
            return $this->requiredString($key);
        } catch (ArgumentRequiredException) {
            return $default;
        }
    }

    /**
     * Get argument value by key as integer
     *
     * @param int|string $key
     * @param int|null $default
     * @return int|null
     * @throws \Spark\Exceptions\Console\UnexpectedTypeException
     */
    protected function int(string|int $key, int|null $default = null): int|null
    {
        try {
            return $this->requiredInt($key);
        } catch (ArgumentRequiredException) {
            return $default;
        }
    }

    /**
     * Get argument value by key as float
     *
     * @param int|string $key
     * @param float|null $default
     * @return float|null
     * @throws \Spark\Exceptions\Console\UnexpectedTypeException
     */
    protected function float(string|int $key, float|null $default = null): float|null
    {
        try {
            return $this->requiredFloat($key);
        } catch (ArgumentRequiredException) {
            return $default;
        }
    }

    /**
     * Get argument value by key as boolean
     *
     * @param int|string $key
     * @param bool|null $default
     * @return bool|null
     * @throws \Spark\Exceptions\Console\UnexpectedTypeException
     */
    protected function bool(string|int $key, bool|null $default = null): bool|null
    {
        try {
            return $this->requiredBool($key);
        } catch (ArgumentRequiredException) {
            return $default;
        }
    }

    /*----------------------------------------*
     * Validation
     *----------------------------------------*/

    /**
     * Validation message
     *
     * @var string
     */
    protected string $validationMessage = "Validation failed";

    /**
     * Validation errors
     *
     * @var array<string, string>
     */
    protected array $validationErrors = [];

    /**
     * Set validation message
     *
     * @param string $message
     * @return void
     */
    protected function setValidationMessage(string $message): void
    {
        $this->validationMessage = $message;
    }

    /**
     * Add validation error
     *
     * @param string $field
     * @param string $error
     * @return void
     */
    protected function addValidationError(string $field, string $error): void
    {
        $this->validationErrors[$field] = $error;
    }

    /**
     * Prepare for validation
     *
     * @return void
     */
    protected function prepareValidation(): void {}

    /**
     * Validate command arguments
     *
     * @return void
     */
    protected function validate(): void {}

    /**
     * Passed validation
     *
     * @return void
     */
    protected function passedValidation(): void {}

    /**
     * Handle failed validation
     *
     * @return void
     * @throws \Spark\Exceptions\Console\ValidationException
     */
    protected function failedValidation(): void
    {
        throw new ValidationException($this->validationMessage, $this->validationErrors);
    }

    /**
     * Validate argument format
     *
     * @param string|int $key
     * @param string $pattern
     * @return bool
     * @throws \Spark\Exceptions\Console\UnexpectedFormatException
     */
    protected function validateFormat(string|int $key, string $pattern): bool
    {
        if (!$this->has($key)) return false;

        $value = $this->arguments[$key];

        if (!preg_match($pattern, (string)$value)) throw new UnexpectedFormatException($key, $pattern);

        return true;
    }

    /*----------------------------------------*
     * Echo
     *----------------------------------------*/

    /**
     * Echo message without newline
     *
     * @param string $message
     * @return void
     */
    protected function echo(string $message): void
    {
        echo $message;

        flush();
    }

    /**
     * Echo message with newline
     *
     * @param string $message
     * @return void
     */
    protected function line(string $message): void
    {
        $this->echo($message . PHP_EOL);
    }

    /**
     * Echo new line
     *
     * @param int $count
     * @return void
     */
    protected function newLine(int $count = 1): void
    {
        for ($i = 0; $i < $count; $i++) {
            $this->echo(PHP_EOL);
        }
    }

    /**
     * Echo carriage return
     *
     * @return void
     */
    protected function carriageReturn(): void
    {
        $this->echo("\r");
    }

    /*----------------------------------------*
     * Output
     *----------------------------------------*/

    /**
     * Create output
     *
     * @param string $text
     * @return \Spark\Contracts\Console\Output
     */
    protected function output(string $text): OutputContract
    {
        return new Output($text);
    }

    /**
     * Echo primary text with newline
     *
     * @param string $text
     * @return void
     */
    protected function primary(string $text): void
    {
        $this->output($text)->brightBlue()->line();
    }

    /**
     * Echo secondary text with newline
     *
     * @param string $text
     * @return void
     */
    protected function secondary(string $text): void
    {
        $this->output($text)->white()->line();
    }

    /**
     * Echo success text with newline
     *
     * @param string $text
     * @return void
     */
    protected function success(string $text): void
    {
        $this->output($text)->brightGreen()->line();
    }

    /**
     * Echo warning text with newline
     *
     * @param string $text
     * @return void
     */
    protected function warning(string $text): void
    {
        $this->output($text)->brightYellow()->line();
    }

    /**
     * Echo error text with newline
     *
     * @param string $text
     * @return void
     */
    protected function error(string $text): void
    {
        $this->output($text)->brightRed()->line();
    }

    /**
     * Echo info text with newline
     *
     * @param string $text
     * @return void
     */
    protected function info(string $text): void
    {
        $this->output($text)->brightCyan()->line();
    }

    /**
     * Echo notice text with newline
     *
     * @param string $text
     * @return void
     */
    protected function notice(string $text): void
    {
        $this->output($text)->brightMagenta()->line();
    }
}
