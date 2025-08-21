<?php

namespace Spark\Contracts\Timer;

use Spark\Contracts\Timer\Timer;

/**
 * Split Timer Contract
 *
 * @package Spark\Contracts\Timer
 */
interface SplitTimer extends Timer
{
    /**
     * record split
     *
     * @return static
     */
    public function split(): static;

    /**
     * get split seconds
     *
     * @return array<float>
     */
    public function splits(): array;

    /**
     * get split count
     *
     * @return int
     */
    public function count(): int;

    /**
     * get split at index
     *
     * @param int $index
     * @return float|null
     */
    public function splitAt(int $index): float|null;

    /**
     * get first split
     *
     * @return float|null
     */
    public function first(): float|null;

    /**
     * get last split
     *
     * @return float|null
     */
    public function last(): float|null;

    /**
     * get fastest split
     *
     * @return float|null
     */
    public function fastest(): float|null;

    /**
     * get slowest split
     *
     * @return float|null
     */
    public function slowest(): float|null;

    /**
     * get average split
     *
     * @return float|null
     */
    public function average(): float|null;
}
