<?php

namespace Spark\Contracts\Timer;

use Spark\Contracts\Timer\Timer;

/**
 * Lap Timer Contract
 *
 * @package Spark\Contracts\Timer
 */
interface LapTimer extends Timer
{
    /**
     * record lap
     *
     * @return static
     */
    public function lap(): static;

    /**
     * get lap seconds
     *
     * @return array<float>
     */
    public function laps(): array;

    /**
     * get lap count
     *
     * @return int
     */
    public function count(): int;

    /**
     * get lap at index
     *
     * @param int $index
     * @return float|null
     */
    public function lapAt(int $index): float|null;

    /**
     * get first lap
     *
     * @return float|null
     */
    public function first(): float|null;

    /**
     * get last lap
     *
     * @return float|null
     */
    public function last(): float|null;

    /**
     * get fastest lap
     *
     * @return float|null
     */
    public function fastest(): float|null;

    /**
     * get slowest lap
     *
     * @return float|null
     */
    public function slowest(): float|null;

    /**
     * get average lap
     *
     * @return float|null
     */
    public function average(): float|null;
}
