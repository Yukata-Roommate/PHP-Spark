<?php

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
     * whether timer is running
     *
     * @return bool
     */
    public function isRunning(): bool;

    /**
     * whether timer is stopped
     *
     * @return bool
     */
    public function isStopped(): bool;

    /**
     * whether timer is idle
     *
     * @return bool
     */
    public function isIdle(): bool;

    /*----------------------------------------*
     * Start
     *----------------------------------------*/

    /**
     * start
     *
     * @return static
     */
    public function start(): static;

    /**
     * get start timestamp
     *
     * @return float
     */
    public function startedAt(): float;

    /*----------------------------------------*
     * Stop
     *----------------------------------------*/

    /**
     * stop
     *
     * @return static
     */
    public function stop(): static;

    /**
     * get stop timestamp
     *
     * @return float
     */
    public function stoppedAt(): float;

    /*----------------------------------------*
     * Reset
     *----------------------------------------*/

    /**
     * reset
     *
     * @return static
     */
    public function reset(): static;

    /**
     * restart
     *
     * @return static
     */
    public function restart(): static;

    /*----------------------------------------*
     * Elapsed
     *----------------------------------------*/

    /**
     * get elapsed seconds
     *
     * @return float
     */
    public function elapsedSeconds(): float;

    /**
     * get elapsed milliseconds
     *
     * @return float
     */
    public function elapsedMilliseconds(): float;

    /**
     * get elapsed minutes
     *
     * @return float
     */
    public function elapsedMinutes(): float;

    /**
     * get elapsed hours
     *
     * @return float
     */
    public function elapsedHours(): float;
}
