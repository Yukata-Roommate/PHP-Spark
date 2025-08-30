<?php

declare(strict_types=1);

namespace Spark\Monitor\Exec;

/**
 * Command Result
 *
 * @package Spark\Monitor\Exec
 */
class CommandResult
{
    /**
     * Constructor
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
     * Output
     *
     * @var array<string>
     */
    protected array $output;

    /**
     * Get output
     *
     * @return array<string>
     */
    public function output(): array
    {
        return $this->output;
    }

    /**
     * Get output iterate
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
     * Get output at specific index
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
     * Whether has output
     *
     * @return bool
     */
    public function hasOutput(): bool
    {
        return !empty($this->output);
    }

    /**
     * Whether has not output
     *
     * @return bool
     */
    public function hasNotOutput(): bool
    {
        return !$this->hasOutput();
    }

    /**
     * Whether has output at specific index
     *
     * @param int $index
     * @return bool
     */
    public function hasOutputAt(int $index): bool
    {
        return $this->hasOutput() && isset($this->output[$index]) && !empty($this->output[$index]);
    }

    /**
     * Whether has not output at specific index
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
     * Code
     *
     * @var int
     */
    protected int $code;

    /**
     * Get code
     *
     * @return int
     */
    public function code(): int
    {
        return $this->code;
    }

    /**
     * Whether code is success
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
     * Whether code is failure
     *
     * @param int|null $index
     * @return bool
     */
    public function isFailure(int|null $index = null): bool
    {
        return !$this->isSuccess($index);
    }
}
