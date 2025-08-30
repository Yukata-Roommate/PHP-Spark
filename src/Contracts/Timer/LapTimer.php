<?php

declare(strict_types=1);

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
     * Record lap
     *
     * @return static
     */
    public function lap(): static;

    /**
     * Get lap seconds
     *
     * @return array<float>
     */
    public function laps(): array;

    /**
     * Get lap count
     *
     * @return int
     */
    public function count(): int;

    /**
     * Get lap at index
     *
     * @param int $index
     * @return float|null
     */
    public function lapAt(int $index): float|null;

    /**
     * Get first lap
     *
     * @return float|null
     */
    public function first(): float|null;

    /**
     * Get last lap
     *
     * @return float|null
     */
    public function last(): float|null;

    /**
     * Get fastest lap
     *
     * @return float|null
     */
    public function fastest(): float|null;

    /**
     * Get slowest lap
     *
     * @return float|null
     */
    public function slowest(): float|null;

    /**
     * Get average lap
     *
     * @return float|null
     */
    public function average(): float|null;
}
