<?php

declare(strict_types=1);

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
     * Record split
     *
     * @return static
     */
    public function split(): static;

    /**
     * Get split seconds
     *
     * @return array<float>
     */
    public function splits(): array;

    /**
     * Get split count
     *
     * @return int
     */
    public function count(): int;

    /**
     * Get split at index
     *
     * @param int $index
     * @return float|null
     */
    public function splitAt(int $index): float|null;

    /**
     * Get first split
     *
     * @return float|null
     */
    public function first(): float|null;

    /**
     * Get last split
     *
     * @return float|null
     */
    public function last(): float|null;

    /**
     * Get fastest split
     *
     * @return float|null
     */
    public function fastest(): float|null;

    /**
     * Get slowest split
     *
     * @return float|null
     */
    public function slowest(): float|null;

    /**
     * Get average split
     *
     * @return float|null
     */
    public function average(): float|null;
}
