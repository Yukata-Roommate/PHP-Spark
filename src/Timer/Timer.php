<?php

declare(strict_types=1);

namespace Spark\Timer;

use Spark\Contracts\Timer\Timer as TimerContract;

/**
 * Timer
 *
 * @package Spark\Timer
 */
class Timer implements TimerContract
{
    /*----------------------------------------*
     * Constructor
     *----------------------------------------*/

    /**
     * Constructor
     *
     * @param callable|null $now
     */
    public function __construct(callable|null $now = null)
    {
        $this->now = $now ?? fn() => microtime(true);
    }

    /*----------------------------------------*
     * State
     *----------------------------------------*/

    /**
     * Whether timer is running
     *
     * @return bool
     */
    public function isRunning(): bool
    {
        return $this->start > 0.0 && $this->stop === 0.0;
    }

    /**
     * Whether timer is stopped
     *
     * @return bool
     */
    public function isStopped(): bool
    {
        return $this->start > 0.0 && $this->stop > 0.0;
    }

    /**
     * Whether timer is idle
     *
     * @return bool
     */
    public function isIdle(): bool
    {
        return $this->start === 0.0 && $this->stop === 0.0;
    }

    /**
     * Ensure timer is running
     *
     * @return void
     */
    protected function ensureRunning(): void
    {
        if ($this->isRunning()) return;

        throw new \RuntimeException("Timer is not running. Please start it before performing this operation.");
    }

    /**
     * Ensure timer is stopped
     *
     * @return void
     */
    protected function ensureStopped(): void
    {
        if ($this->isStopped()) return;

        throw new \RuntimeException("Timer is not stopped. Please stop it before performing this operation.");
    }

    /**
     * Ensure timer is idle
     *
     * @return void
     */
    protected function ensureIdle(): void
    {
        if ($this->isIdle()) return;

        throw new \RuntimeException("Timer is not idle. Please reset it before performing this operation.");
    }

    /*----------------------------------------*
     * Start
     *----------------------------------------*/

    /**
     * Start timestamp
     *
     * @var float
     */
    protected float $start = 0.0;

    /**
     * Start
     *
     * @return static
     */
    public function start(): static
    {
        $this->ensureIdle();

        $now = $this->now();

        $this->start = $now;

        $this->onStart($now);

        return $this;
    }

    /**
     * On start
     *
     * @param float $now
     * @return void
     */
    protected function onStart(float $now): void {}

    /**
     * Get start timestamp
     *
     * @return float
     */
    public function startedAt(): float
    {
        return $this->start;
    }

    /*----------------------------------------*
     * Stop
     *----------------------------------------*/

    /**
     * Stop timestamp
     *
     * @var float
     */
    protected float $stop = 0.0;

    /**
     * Stop
     *
     * @return static
     */
    public function stop(): static
    {
        $this->ensureRunning();

        $now = $this->now();

        $this->stop = $now;

        $this->onStop($now);

        return $this;
    }

    /**
     * On stop
     *
     * @param float $now
     * @return void
     */
    protected function onStop(float $now): void {}

    /**
     * Get stop timestamp
     *
     * @return float
     */
    public function stoppedAt(): float
    {
        return $this->stop;
    }

    /*----------------------------------------*
     * Reset
     *----------------------------------------*/

    /**
     * Reset
     *
     * @return static
     */
    public function reset(): static
    {
        $this->start = 0.0;
        $this->stop  = 0.0;

        $this->onReset();

        return $this;
    }

    /**
     * On reset
     *
     * @return void
     */
    protected function onReset(): void {}

    /**
     * Restart
     *
     * @return static
     */
    public function restart(): static
    {
        return $this->reset()->start();
    }

    /*----------------------------------------*
     * Elapsed
     *----------------------------------------*/

    /**
     * Get elapsed seconds
     *
     * @return float
     */
    public function elapsedSeconds(): float
    {
        if ($this->isIdle()) return 0.0;

        $endTimestamp = $this->isRunning() ? $this->now() : $this->stop;

        return $endTimestamp - $this->start;
    }

    /**
     * Get elapsed milliseconds
     *
     * @return float
     */
    public function elapsedMilliseconds(): float
    {
        return $this->elapsedSeconds() * 1000.0;
    }

    /**
     * Get elapsed minutes
     *
     * @return float
     */
    public function elapsedMinutes(): float
    {
        return $this->elapsedSeconds() / 60.0;
    }

    /**
     * Get elapsed hours
     *
     * @return float
     */
    public function elapsedHours(): float
    {
        return $this->elapsedSeconds() / 3600.0;
    }

    /*----------------------------------------*
     * Now
     *----------------------------------------*/

    /**
     * Now factory
     *
     * @var callable
     */
    protected callable $now;

    /**
     * Get current timestamp
     *
     * @return float
     */
    protected function now(): float
    {
        return ($this->now)();
    }
}
