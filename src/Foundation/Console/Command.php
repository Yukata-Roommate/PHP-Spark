<?php

namespace Spark\Foundation\Console;

use Spark\Contracts\Console\Command as CommandContract;

use Spark\Contracts\Console\Output as OutputContract;
use Spark\Console\Output;

/**
 * Command
 *
 * @package Spark\Foundation\Console
 */
abstract class Command implements CommandContract
{
    /*----------------------------------------*
     * Property
     *----------------------------------------*/

    /**
     * signature
     *
     * @var string
     */
    protected string $signature;

    /**
     * description
     *
     * @var string
     */
    protected string $description;

    /**
     * get signature
     *
     * @return string
     */
    public function signature(): string
    {
        return $this->signature;
    }

    /**
     * get description
     *
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /*----------------------------------------*
     * Run
     *----------------------------------------*/

    /**
     * run command
     *
     * @param array $arguments
     * @return void
     */
    public function run(array $arguments): void
    {
        $this->arguments = $arguments;

        $this->prepareValidation();

        if (!$this->validate()) $this->failedValidation();

        $this->passedValidation();

        $this->execute();
    }

    /**
     * execute
     *
     * @return void
     */
    abstract protected function execute(): void;

    /*----------------------------------------*
     * Arguments
     *----------------------------------------*/

    /**
     * arguments
     *
     * @var array
     */
    protected array $arguments;

    /**
     * get arguments
     *
     * @return array<string|int, string|int>
     */
    protected function arguments(): array
    {
        return $this->arguments;
    }

    /**
     * whether arguments contain key
     *
     * @param int|string $key
     * @return bool
     */
    protected function has(string|int $key): bool
    {
        return isset($this->arguments[$key]) && !empty($this->arguments[$key]);
    }

    /**
     * get argument by key
     *
     * @param int|string $key
     * @return int|string|null
     */
    protected function get(string|int $key): int|string|null
    {
        return $this->has($key) ? $this->arguments[$key] : null;
    }

    /*----------------------------------------*
     * Validation
     *----------------------------------------*/

    /**
     * prepare validation
     *
     * @return void
     */
    protected function prepareValidation(): void {}

    /**
     * validate command arguments
     *
     * @return bool
     */
    protected function validate(): bool
    {
        return true;
    }

    /**
     * passed validation
     *
     * @return void
     */
    protected function passedValidation(): void {}

    /**
     * handle failed validation
     *
     * @return void
     */
    protected function failedValidation(): void
    {
        throw new \InvalidArgumentException("Invalid command arguments");
    }

    /*----------------------------------------*
     * Echo
     *----------------------------------------*/

    /**
     * echo message
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
     * echo line
     *
     * @param string $message
     * @return void
     */
    protected function line(string $message): void
    {
        $this->echo($message . PHP_EOL);
    }

    /**
     * echo new line
     *
     * @return void
     */
    protected function newLine(): void
    {
        $this->echo(PHP_EOL);
    }

    /**
     * echo carriage return
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
     * make output
     *
     * @param string $text
     * @return \Spark\Contracts\Console\Output
     */
    protected function output(string $text): OutputContract
    {
        return new Output($text);
    }

    /**
     * echo line primary text
     *
     * @param string $text
     * @return void
     */
    protected function primary(string $text): void
    {
        $this->output($text)->brightBlue()->line();
    }

    /**
     * echo line secondary text
     *
     * @param string $text
     * @return void
     */
    protected function secondary(string $text): void
    {
        $this->output($text)->white()->line();
    }

    /**
     * echo line success text
     *
     * @param string $text
     * @return void
     */
    protected function success(string $text): void
    {
        $this->output($text)->brightGreen()->line();
    }

    /**
     * echo line warning text
     *
     * @param string $text
     * @return void
     */
    protected function warning(string $text): void
    {
        $this->output($text)->brightYellow()->line();
    }

    /**
     * echo line error text
     *
     * @param string $text
     * @return void
     */
    protected function error(string $text): void
    {
        $this->output($text)->brightRed()->line();
    }

    /**
     * echo line info text
     *
     * @param string $text
     * @return void
     */
    protected function info(string $text): void
    {
        $this->output($text)->brightCyan()->line();
    }

    /**
     * echo line notice text
     *
     * @param string $text
     * @return void
     */
    protected function notice(string $text): void
    {
        $this->output($text)->brightMagenta()->line();
    }
}
