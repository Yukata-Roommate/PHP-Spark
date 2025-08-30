<?php

declare(strict_types=1);

namespace Spark\Timer;

use Spark\Contracts\Timer\SplitTimer as SplitTimerContract;
use Spark\Timer\Timer;

/**
 * Split Timer
 *
 * @package Spark\Time
 */
class SplitTimer extends Timer implements SplitTimerContract
{
    /*----------------------------------------*
     * Stop
     *----------------------------------------*/

    /**
     * On stop
     *
     * @param float $now
     * @return void
     */
    #[\Override]
    protected function onStop(float $now): void
    {
        $this->addSplit($now);
    }

    /*----------------------------------------*
     * Reset
     *----------------------------------------*/

    /**
     * On reset
     *
     * @return void
     */
    #[\Override]
    protected function onReset(): void
    {
        $this->splits = [];
    }

    /*----------------------------------------*
     * Split
     *----------------------------------------*/

    /**
     * Split seconds
     *
     * @var array<float>
     */
    protected array $splits = [];

    /**
     * Record split
     *
     * @return static
     */
    public function split(): static
    {
        $this->addSplit($this->now());

        return $this;
    }

    /**
     * Add split seconds
     *
     * @param float $timestamp
     * @return void
     */
    protected function addSplit(float $timestamp): void
    {
        $this->ensureRunning();

        $this->splits[] = $timestamp - $this->start;
    }

    /**
     * Get split seconds
     *
     * @return array<float>
     */
    public function splits(): array
    {
        return $this->splits;
    }

    /**
     * Get split count
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->splits);
    }

    /**
     * Get split at index
     *
     * @param int $index
     * @return float|null
     */
    public function splitAt(int $index): float|null
    {
        return $this->splits[$index] ?? null;
    }

    /**
     * Get first split
     *
     * @return float|null
     */
    public function first(): float|null
    {
        return $this->splitAt(0);
    }

    /**
     * Get last split
     *
     * @return float|null
     */
    public function last(): float|null
    {
        return $this->splitAt($this->count() - 1);
    }

    /**
     * Get fastest split
     *
     * @return float|null
     */
    public function fastest(): float|null
    {
        return empty($this->splits) ? null : min($this->splits);
    }

    /**
     * Get slowest split
     *
     * @return float|null
     */
    public function slowest(): float|null
    {
        return empty($this->splits) ? null : max($this->splits);
    }

    /**
     * Get average split
     *
     * @return float|null
     */
    public function average(): float|null
    {
        if (empty($this->splits)) return null;

        return array_sum($this->splits) / count($this->splits);
    }
}
