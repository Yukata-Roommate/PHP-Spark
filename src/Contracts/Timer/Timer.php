<?php

declare(strict_types=1);

namespace Spark\Contracts\Timer;

/**
 * Timer Contract
 *
 * @package Spark\Contracts\Timer
 */
interface Timer
{
    /*----------------------------------------*
     * State
     *----------------------------------------*/

    /**
     * Whether timer is running
     *
     * @return bool
     */
    public function isRunning(): bool;

    /**
     * Whether timer is stopped
     *
     * @return bool
     */
    public function isStopped(): bool;

    /**
     * Whether timer is idle
     *
     * @return bool
     */
    public function isIdle(): bool;

    /*----------------------------------------*
     * Start
     *----------------------------------------*/

    /**
     * Start
     *
     * @return static
     */
    public function start(): static;

    /**
     * Get start timestamp
     *
     * @return float
     */
    public function startedAt(): float;

    /*----------------------------------------*
     * Stop
     *----------------------------------------*/

    /**
     * Stop
     *
     * @return static
     */
    public function stop(): static;

    /**
     * Get stop timestamp
     *
     * @return float
     */
    public function stoppedAt(): float;

    /*----------------------------------------*
     * Reset
     *----------------------------------------*/

    /**
     * Reset
     *
     * @return static
     */
    public function reset(): static;

    /**
     * Restart
     *
     * @return static
     */
    public function restart(): static;

    /*----------------------------------------*
     * Elapsed
     *----------------------------------------*/

    /**
     * Get elapsed seconds
     *
     * @return float
     */
    public function elapsedSeconds(): float;

    /**
     * Get elapsed milliseconds
     *
     * @return float
     */
    public function elapsedMilliseconds(): float;

    /**
     * Get elapsed minutes
     *
     * @return float
     */
    public function elapsedMinutes(): float;

    /**
     * Get elapsed hours
     *
     * @return float
     */
    public function elapsedHours(): float;
}
