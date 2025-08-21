<?php

namespace Spark\Timer;

use Spark\Contracts\Timer\LapTimer as LapTimerContract;
use Spark\Timer\Timer;

/**
 * Lap Timer
 *
 * @package Spark\Timer
 */
class LapTimer extends Timer implements LapTimerContract
{
    /*----------------------------------------*
     * Stop
     *----------------------------------------*/

    /**
     * on stop
     *
     * @param float $now
     * @return void
     */
    #[\Override]
    protected function onStop(float $now): void
    {
        $this->addLap($now);
    }

    /*----------------------------------------*
     * Reset
     *----------------------------------------*/

    /**
     * on reset
     *
     * @return void
     */
    #[\Override]
    protected function onReset(): void
    {
        $this->laps             = [];
        $this->lastLapTimestamp = null;
    }

    /*----------------------------------------*
     * Lap
     *----------------------------------------*/

    /**
     * lap seconds
     *
     * @var array<float>
     */
    protected array $laps = [];

    /**
     * last lap timestamp
     *
     * @var float|null
     */
    protected float|null $lastLapTimestamp = null;

    /**
     * record lap
     *
     * @return static
     */
    public function lap(): static
    {
        $this->addLap($this->now());

        return $this;
    }

    /**
     * add lap seconds
     *
     * @param float $timestamp
     * @return void
     */
    protected function addLap(float $timestamp): void
    {
        $this->ensureRunning();

        $previousTimestamp = $this->lastLapTimestamp ?? $this->start;

        $this->laps[] = $timestamp - $previousTimestamp;

        $this->lastLapTimestamp = $timestamp;
    }

    /**
     * get lap seconds
     *
     * @return array<float>
     */
    public function laps(): array
    {
        return $this->laps;
    }

    /**
     * get lap count
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->laps);
    }

    /**
     * get lap at index
     *
     * @param int $index
     * @return float|null
     */
    public function lapAt(int $index): float|null
    {
        return $this->laps[$index] ?? null;
    }

    /**
     * get first lap
     *
     * @return float|null
     */
    public function first(): float|null
    {
        return $this->lapAt(0);
    }

    /**
     * get last lap
     *
     * @return float|null
     */
    public function last(): float|null
    {
        return $this->lapAt($this->count() - 1);
    }

    /**
     * get fastest lap
     *
     * @return float|null
     */
    public function fastest(): float|null
    {
        return empty($this->laps) ? null : min($this->laps);
    }

    /**
     * get slowest lap
     *
     * @return float|null
     */
    public function slowest(): float|null
    {
        return empty($this->laps) ? null : max($this->laps);
    }

    /**
     * get average lap
     *
     * @return float|null
     */
    public function average(): float|null
    {
        if (empty($this->laps)) return null;

        return array_sum($this->laps) / count($this->laps);
    }
}
