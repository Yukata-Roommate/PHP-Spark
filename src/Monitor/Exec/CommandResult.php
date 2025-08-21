<?php

namespace Spark\Monitor\Exec;

/**
 * Command Result
 *
 * @package Spark\Monitor\Exec
 */
class CommandResult
{
    /**
     * constructor
     *
     * @param array $output
     * @param int $code
     */
    public function __construct(array $output, int $code)
    {
        $this->output = $output;
        $this->code   = $code;
    }

    /*----------------------------------------*
     * Output
     *----------------------------------------*/

    /**
     * output
     *
     * @var array<string>
     */
    protected array $output;

    /**
     * get output
     *
     * @return array<string>
     */
    public function output(): array
    {
        return $this->output;
    }

    /**
     * get output iterate
     *
     * @return \Generator<string>
     */
    public function outputIterate(): \Generator
    {
        foreach ($this->output as $line) {
            yield $line;
        }
    }

    /**
     * get output at specific index
     *
     * @param int $index
     * @return string
     */
    public function outputAt(int $index): string
    {
        if (!isset($this->output[$index])) throw new \OutOfBoundsException("Output index {$index} does not exist.");

        return $this->output[$index];
    }

    /**
     * whether has output
     *
     * @return bool
     */
    public function hasOutput(): bool
    {
        return !empty($this->output);
    }

    /**
     * whether has not output
     *
     * @return bool
     */
    public function hasNotOutput(): bool
    {
        return !$this->hasOutput();
    }

    /**
     * whether has output at specific index
     *
     * @param int $index
     * @return bool
     */
    public function hasOutputAt(int $index): bool
    {
        return $this->hasOutput() && isset($this->output[$index]) && !empty($this->output[$index]);
    }

    /**
     * whether has not output at specific index
     *
     * @param int $index
     * @return bool
     */
    public function hasNotOutputAt(int $index): bool
    {
        return !$this->hasOutputAt($index);
    }

    /*----------------------------------------*
     * Code
     *----------------------------------------*/

    /**
     * code
     *
     * @var int
     */
    protected int $code;

    /**
     * get code
     *
     * @return int
     */
    public function code(): int
    {
        return $this->code;
    }

    /**
     * whether code is success
     *
     * @param int|null $index
     * @return bool
     */
    public function isSuccess(int|null $index = null): bool
    {
        if ($this->code !== 0) return false;

        return is_null($index) ? $this->hasOutput() : $this->hasOutputAt($index);
    }

    /**
     * whether code is failure
     *
     * @param int|null $index
     * @return bool
     */
    public function isFailure(int|null $index = null): bool
    {
        return !$this->isSuccess($index);
    }
}
